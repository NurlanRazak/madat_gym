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
use App\DoneExersice;
use App\View;
use App\Session;

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
        'date_birth', 'gender', 'current_weight', 'height', 'iin', 'phone_number', 'social_media', 'comment', 'date_register', 'position', 'date_hired', 'date_fired', 'address','image'
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
            $programtraining_id = $user->getOriginal('programtraining_id');
            $date = $user->getOriginal('programtraining_start');
            if ($programtraining_id) {
                $user->programHistories()->create([
                    'programtraining_id' => $programtraining_id,
                    'program_date' => $date,
                ]);
            }
        });
    }

    public function getTrainings(bool $nextWeek = false)
    {
        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($this->real_programtraining_start->format('Y-m-d h:m')))/60/60/24 + ($nextWeek ? 7 : 0);
        $passed = intval($passed);
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
        $today = ($today ? $today : \Date::today())->dayOfWeek;
        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($this->real_programtraining_start->format('Y-m-d h:m')))/60/60/24 + ($nextWeek ? 7 : 0);
        $passed = intval($passed);

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
        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($this->real_programtraining_start->format('Y-m-d h:m')))/60/60/24 + ($nextWeek ? 7 : 0);
        $passed = intval($passed);
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
        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($this->real_programtraining_start->format('Y-m-d h:m')))/60/60/24 + ($nextWeek ? 7 : 0);
        $passed = intval($passed);
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
        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($this->real_programtraining_start->format('Y-m-d h:m')))/60/60/24 + ($nextWeek ? 7 : 0);
        $passed = intval($passed);
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
                    ->orderBy('time')
                    ->get();
    }

    public function checkExersice($weekDay, $key) : bool
    {
        $passed = (strtotime(\Carbon\Carbon::now()->format('Y-m-d h:m')) - strtotime($this->real_programtraining_start->format('Y-m-d h:m')))/60/60/24;
        $passed = intval($passed);
        $today = \Date::today()->dayOfWeek;
        if ($today == 0) {
            $today = 7;
        }
        $day = $passed + $today - $weekDay;
        return $this->doneExersices()->where('key', $key)->where('day_number', $day)->exists();
    }

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

    public function getRealProgramtrainingStartAttribute()
    {
        if ($this->subscriptions()->where('bought_at', '>=', $this->programtraining_start)->count() > 1) {
            $subscriptions = $this->subscriptions()->where('bought_at', '>=', $this->programtraining_start)->orderBy('pivot_created_at', 'desc')->get();
            $diff = (strtotime($subscriptions[0]->pivot->created_at->format('Y-m-d h:m')) - strtotime($subscriptions[1]->pivot->created_at->format('Y-m-d h:m')))/60/60/24 - $subscriptions[0]->days;

            return \Carbon\Carbon::parse($this->programtraining_start)->addDays($diff);
        }
        return \Carbon\Carbon::parse($this->programtraining_start);
    }


    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = 'uploads'; // or use your own disk, defined in config/filesystems.php
        $destination_path = "users/employee"; // path relative to the disk above

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value)->encode('jpg', 90);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the public path to the database
        // but first, remove "public/" from the path, since we're pointing to it from the root folder
        // that way, what gets saved in the database is the user-accesible URL
            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);
            $this->attributes[$attribute_name] = $public_destination_path.'/'.$filename;
        } else {
            $this->attributes[$attribute_name] = \Storage::disk($disk)->put($destination_path, $value);
        }
    }

}
