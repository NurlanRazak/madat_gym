<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerify;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Message;
use App\Models\Subscription;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use App\Models\Pivots\MessageUser;
use App\Models\Programtraining;
use App\Models\Userparameter;
use App\Models\Pivots\SubscriptionUser;
use App\Models\Pivots\ProgramtrainingUser;
use App\DoneExersice;
use App\View;
use App\Session;
use Image;
use Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;
    use MustVerify;

    protected $guard_name = 'web';
    protected $statistics = null;

    const MALE=1;
    const FEMALE=2;
    const WORKER=1;
    const TRANER=2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'middle_name', 'email', 'password', 'country', 'type_employee', 'city',
        'programtraining_id', 'programtraining_start',
        'date_birth', 'gender', 'current_weight', 'height', 'iin', 'phone_number', 'social_media', 'comment', 'date_register', 'position', 'date_hired', 'date_fired', 'address','image',
        'is_notifiable', 'is_auto_renewal'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function views()
    {
        return $this->hasMany(View::class, 'user_id');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id');
    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_user', 'user_id', 'message_id')
                    ->withPivot(['read_at'])
                    ->using(MessageUser::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'subscription_user', 'user_id', 'subscription_id')
                    ->withPivot(['created_at', 'id', 'bought_at'])
                    ->using(SubscriptionUser::class);
    }

    public function rawsubscriptions()
    {
        return $this->hasMany(SubscriptionUser::class, 'user_id');
    }

    public function userparameters()
    {
        return $this->hasMany(Userparameter::class, 'user_id');
    }

    public function programtraining()
    {
        return $this->belongsTo(Programtraining::class, 'programtraining_id');
    }

    public function programtrainings()
    {
        return $this->belongsToMany(Programtraining::class, 'programtraining_user', 'user_id', 'programtraining_id')
                    ->withPivot(['status', 'bought_at', 'days_left', 'total_days'])
                    ->using(ProgramtrainingUser::class);
    }

    public function doneExersices()
    {
        return $this->hasMany(DoneExersice::class, 'user_id');
    }

    public function programHistories()
    {
        return $this->hasMany('App\Models\ProgramHistory', 'user_id');
    }

    public static function getGenderOptions() : array
    {
        return [
            static::MALE => 'Мужской пол',
            static::FEMALE => 'Женский пол',
        ];
    }

    public static function getEmployeetypeOptions() : array
    {
        return [
            static::WORKER => 'Сотрудник',
            static::TRANER => 'Тренер',
        ];
    }
    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('uploads')->delete($obj->image);
        });

        static::created(function($obj) {
            // dd($obj);
            if (backpack_user()) {
                $obj->sendEmailVerificationNotification();
            }
        });

        static::updating(function($user) {
            if ($user->isDirty('programtraining_id')) {
                $program = Programtraining::findOrFail($user->programtraining_id);
                if (!$user->programtrainings()->wherePivot('status', ProgramtrainingUser::ACTIVE)->exists()) {
                    $user->programtrainings()->attach([
                        $user->programtraining_id => [
                            'bought_at' => null,
                            'total_days' => $program->duration,
                            'days_left' => $program->duration,
                            'status' => ProgramtrainingUser::ACTIVE,
                        ],
                    ]);
                }
                $user->programHistories()->create([
                    'programtraining_id' => $user->programtraining_id,
                    'program_date' => now(),
                ]);

                $content = 'Программа - '.$program->name.' активирована.';

                $user->messages()->create([
                        'author_id' => static::role('superadmin')->first()->id,
                        'status' => Message::SENT,
                        'name' => 'Программа активна',
                        'content' => $content,
                ]);
            }
        });
    }

    public function getTrainings(bool $nextWeek = false)
    {
        $passed = $this->getProgramtrainginDaysPassed() + ($nextWeek ? 7 : 0);

        $today = \Date::today()->dayOfWeek;

        return $this->programtraining
                    ->trainings()
                    ->where('day_number', '>=', $passed - $today + 1)
                    ->where('day_number', '<=', $passed - $today + 7)
                    ->with(['exercises' => function($q) {$q->active();}])
                    ->active()
                    ->get();
    }

    public function getEquipments(bool $nextWeek = false, $today = null)
    {
        $passed = $this->getProgramtrainginDaysPassed() + ($nextWeek ? 7 : 0);

        $today = ($today ? $today : \Date::today())->dayOfWeek;


        if($today == 0) {
            $today = 7;
        }

        return $this->programtraining
                    ->equipments()
                    ->where('notify_day', '>=', $passed - $today + 1)
                    ->where('notify_day', '<=', $passed - $today + 7)
                    ->active()
                    ->get();
    }

    public function getGroceries(bool $nextWeek = false)
    {
        $passed = $this->getProgramtrainginDaysPassed() + ($nextWeek ? 7 : 0);

        $today = \Date::today()->dayOfWeek;

        return $this->programtraining
                    ->groceries()
                    ->where('notify_day', '>=', $passed - $today + 1)
                    ->where('notify_day', '<=', $passed - $today + 7)
                    ->active()
                    ->get();
    }

    public function getPlaneats(bool $nextWeek = false, $today = null)
    {
        $passed = $this->getProgramtrainginDaysPassed() + ($nextWeek ? 7 : 0);

        $today = ($today ? $today : \Date::today())->dayOfWeek;

        return $this->programtraining
                    ->foodprogram
                    ->planeats()
                    ->where('days', '>=', $passed - $today + 1)
                    ->where('days', '<=', $passed - $today + 7)
                    ->active()
                    ->with(['meals' => function($q) {$q->active();}])
                    ->with(['eathours' => function($q) {$q->active();}])
                    ->get();
    }

    public function getRelaxtrainings(bool $nextWeek = false)
    {
        $passed = $this->getProgramtrainginDaysPassed() + ($nextWeek ? 7 : 0);

        $today = \Date::today()->dayOfWeek;

        $id = $this->id;
        return $this->programtraining
                    ->relaxprogram
                    ->relaxtrainings()
                    // ->whereHas('users', function($query) use($id) {
                    //     $query->where('id', $id);
                    // })
                    ->where('number_day', '>=', $passed - $today + 1)
                    ->where('number_day', '<=', $passed - $today + 7)
                    ->active()
                    ->with(['exercises' => function($q) {$q->active();}])
                    ->orderBy('hour_start')
                    ->get();
    }

    public function checkExersice($weekDay, $key) : bool
    {
        $passed = $this->getProgramtrainginDaysPassed();

        $today = \Date::today()->dayOfWeek;
        if ($today == 0) {
            $today = 7;
        }
        $day = $passed + $today - $weekDay;
        return $this->doneExersices()->where('key', $key)->where('day_number', $day)->exists();
    }

    // TODO: fix
    public function getStatisticsAttribute()
    {
        if ($this->statistics) {
            return $this->statistics;
        }

        if (!$this->programtraining) {
            return 0;
        }

        $duration = $this->programtraining->duration;
        $all = $duration * 3;
        $passed = $this->doneExersices()->count();
        if ($all == 0) {
            $this->statistics = 100;
        } else {
            $this->statistics = ceil(100 * $passed / $all);
        }
        return $this->statistics;
    }

    public function getNextProgramtrainingAttribute()
    {
        return $this->programtrainings()->wherePivot('status', ProgramtrainingUser::WILL_BE_ACTIVE)->first();
    }

    public function getCurrentProgramtrainingAttribute()
    {
        return $this->programtrainings()->wherePivot('status', ProgramtrainingUser::ACTIVE)->wherePivot('programtraining_id', $this->programtraining_id)->first();
    }

    public function isActive($program) : bool
    {
        return $this->programtraining_id == $program->id;
    }

    public function isNext($program) : bool
    {
        return $this->next_programtraining ? $this->next_programtraining->id == $program->id : false;
    }

    public function hasProgram($program) : bool
    {
        return $this->programtrainings()->wherePivot('programtraining_id', $program->id)->exists();
    }

    public function getProgramtrainginDaysPassed() : int
    {
        $program = $this->current_programtraining;
        if (!$program) {
            return 0;
        }
        return $program->pivot->total_days - $program->pivot->days_left;
    }

    public function setCurrentUserProgram($program)
    {
        ProgramtrainingUser::where('user_id', $this->id)->whereIn('status', [ProgramtrainingUser::WILL_BE_ACTIVE, ProgramtrainingUser::ACTIVE])->update([
            'status' => ProgramtrainingUser::NOT_ACTIVE,
        ]);

        $next = ProgramtrainingUser::where('user_id', $this->id)->where('programtraining_id', $program->id)->first();

        if ($next) {
            $next->update([
                'status' => ProgramtrainingUser::ACTIVE,
            ]);
        } else {
            $this->programtrainings()->attach([
                $program->id => [
                    'bought_at' => null,
                    'total_days' => $program->duration,
                    'days_left' => $program->duration,
                    'status' => ProgramtrainingUser::ACTIVE,
                ],
            ]);
        }

        $this->programtraining_id = $program->id;
        $this->programtraining_start = now();
        $this->save();
    }

    public function addUserProgram($program)
    {
        $pivot = ProgramtrainingUser::where('user_id', $this->id)->where('programtraining_id', $program->id)->where('days_left', '>=', 0)->first();
        if (!$pivot) {
            $this->programtrainings()->attach([
                $program->id => [
                    'bought_at' => null,
                    'days_left' => $program->duration,
                    'status' => ProgramtrainingUser::NOT_ACTIVE,
                ],
            ]);
        }
    }

    public function setNextUserProgram($program)
    {
        ProgramtrainingUser::where('user_id', $this->id)->where('status', ProgramtrainingUser::WILL_BE_ACTIVE)->update([
            'status' => ProgramtrainingUser::NOT_ACTIVE,
        ]);

        // if (!ProgramtrainingUser::where('user_id', $this->id)->where('status', ProgramtrainingUser::ACTIVE)->exists()) {
        //     return $this->setCurrentUserProgram($program);
        // }

        $content = 'Программа - '.$program->name.' будет активирована в следующий понедельник.';

        $this->messages()->create([
            'author_id' => static::role('superadmin')->first()->id,
            'status' => Message::SENT,
            'name' => 'Программа изменена',
            'content' => $content,
        ]);

        $pivot = ProgramtrainingUser::where('user_id', $this->id)->where('programtraining_id', $program->id)->where('days_left', '>=', 0)->first();
        if ($pivot) {
            return $pivot->update([
                'status' => ProgramtrainingUser::WILL_BE_ACTIVE,
            ]);
        }

        return $this->programtrainings()->attach([
            $program->id => [
                'bought_at' => null,
                'days_left' => $program->duration,
                'status' => ProgramtrainingUser::WILL_BE_ACTIVE,
            ],
        ]);
    }

    public function setImageAttribute($value, $attribute_name = 'image')
    {
        $disk = "uploads";
        $destination_path = "users/employee";

        if ($value==null) {
            if (isset($this->attributes[$attribute_name])) {
                try {
                    if (strpos($this->attributes[$attribute_name], "$destination_path")) {
                         $path = str_replace(asset($destination_path).'/', '', $this->attributes[$attribute_name]);
                        \Storage::disk($disk)->delete($path);
                    }
                } catch (\Excepetion $e) {}
            }
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            if (isset($this->attributes[$attribute_name])) {
                try {
                    if (strpos($this->attributes[$attribute_name], "$destination_path")) {
                         $path = str_replace(asset($destination_path).'/', '', $this->attributes[$attribute_name]);
                        \Storage::disk($disk)->delete($path);
                    }
                } catch (\Excepetion $e) {}
            }

            $image = Image::make($value);
            $filename = md5($value.time()).'.jpg';
            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        } else if($value) {
            $this->attributes[$attribute_name] = Storage::disk($disk)->put($destination_path, $value);
        }
    }

    public function adminImage()
    {
        if ($this->image) {
            return url('uploads/'.$this->image);
        }

        $firstLetter = ucfirst($this->name[0] ?? $this->email[0]);
        $placeholder = 'https://placehold.it/160x160/00a65a/ffffff/&text='.$firstLetter;

        if (backpack_users_have_email()) {
            return \Gravatar::fallback('https://placehold.it/160x160/00a65a/ffffff/&text='.$firstLetter)->get($this->email);
        } else {
            return $placeholder;
        }

    }

}
