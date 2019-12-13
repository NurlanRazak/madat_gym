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

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use CrudTrait;
    use HasRoles;
    use MustVerify;

    protected $guard_name = 'web';

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

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'message_user', 'user_id', 'message_id')
                    ->withPivot(['read_at'])
                    ->using(MessageUser::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class, 'subscription_user', 'user_id', 'subscription_id')
                    ->withPivot(['created_at', 'id'])
                    ->using(SubscriptionUser::class);
    }

    public function userparameters()
    {
        return $this->hasMany(Userparameter::class, 'user_id');
    }

    public function programtraining()
    {
        return $this->belongsTo(Programtraining::class, 'programtraining_id');
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
        $this->notify(new VerifyEmail);
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
            $obj->sendEmailVerificationNotification();
        });
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
        }
    }

}
