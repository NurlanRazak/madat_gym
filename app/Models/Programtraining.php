<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Str;
use App\Models\Activeprogram;
use App\Models\Equipment;
use App\Models\Training;
use App\Models\Grocery;
use App\User;

class Programtraining extends Model
{
    use CrudTrait;

    const KZT = 0;
    const USD = 1;
    const EUR = 2;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'programtrainings';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'agerestrict', 'description', 'image', 'duration', 'price', 'programtype_id', 'foodprogram_id', 'relaxprogram_id', 'active', 'currency'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
        \Storage::disk('uploads')->delete($obj->image);
        });
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function programtype()
    {
        return $this->belongsTo('App\Models\Programtype', 'programtype_id');
    }

    public function foodprogram()
    {
        return $this->belongsTo('App\Models\Foodprogram', 'foodprogram_id');
    }

    public function relaxprogram()
    {
        return $this->belongsTo('App\Models\Relaxprogram', 'relaxprogram_id');
    }

    public function activeprograms()
    {
        return $this->hasMany(Activeprogram::class, 'program_id');
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'programtraining_id');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'training_programtraining', 'programtraining_id', 'training_id');
    }

    public function groceries()
    {
        return $this->hasMany(Grocery::class, 'programtraining_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'programtraining_id');
    }

    public function programHistories()
    {
        return $this->hasMany('App\Models\ProgramHistory', 'programtraining_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public static function getCurrencyOptions()
    {
        return [
            static::KZT => 'Тенге',
            static::USD => 'Доллар',
            static::EUR => 'Евро',
        ];
    }

    public static function getCurrencyKeys()
    {
        return [
            static::KZT => 'KZT',
            static::USD => 'USD',
            static::EUR => 'EUR',
        ];
    }

    public static function getCurrencyIcons()
    {
        return [
            static::KZT => '₸',
            static::USD => '$',
            static::EUR => '€',
        ];
    }

    public function getCurrencyIcon()
    {
        return static::getCurrencyIcons()[$this->currency];
    }

    public function getCurrencyKey(int $currency)
    {
        return static::getCurrencyKeys()[$currency];
    }

    public function getUsersCountAttribute()
    {
        return $this->users()->whereDoesntHave('roles')->count();
    }

    public function getEvents($start_date)
    {
        $events = [];

        foreach($this->trainings()->active()->get() as $training) {
            $day = \Carbon\Carbon::parse($start_date)->addDays($training->day_number - 1);
            $events[] = [
                'title' => $training->name,
                'allDay' => false,
                'start' => $day->setTime(16, 0)->format('D M d Y H:i:s O'),
                'end' => $day->setTime(17, 0)->format('D M d Y H:i:s O'),
                'color' => '#d22346',
            ];
        }
        foreach($this->relaxprogram->relaxtrainings()->active()->get() as $relaxtraining) {
            $day = \Carbon\Carbon::parse($start_date)->addDays($relaxtraining->number_day - 1);
            $events[] = [
                'title' => $relaxtraining->name,
                'allDay' => false,
                'start' => $day->setTime(explode(':', $relaxtraining->time)[0] ?? 0, explode(':', $relaxtraining->time)[1] ?? 0)->format('D M d Y H:i:s O'),
                'end' => $day->setTime(explode(':', $relaxtraining->time)[0] ?? 0, explode(':', $relaxtraining->time)[1] ?? 0)->addMinutes(15)->format('D M d Y H:i:s O'),
                'color' => '#ffc107',
            ];
        }

        foreach($this->foodprogram->planeats()->active()->get() as $planeat) {
            $day = \Carbon\Carbon::parse($start_date)->addDays($planeat->days - 1);
            foreach($planeat->eathours ?? [] as $eathour) {
                $events[] = [
                    'title' => $eathour->name,
                    'allDay' => false,
                    'start' => $day->setTime(explode(':', $eathour->hour_start)[0] ?? 0, explode(':', $eathour->hour_start)[1] ?? 0)->format('D M d Y H:i:s O'),
                    'end' => $day->setTime(explode(':', $eathour->hour_finish)[0] ?? 0, explode(':', $eathour->hour_finish)[1] ?? 0)->format('D M d Y H:i:s O'),
                    'color' => '#4caf50',
                ];
            }
        }

        return $events;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = 'uploads'; // or use your own disk, defined in config/filesystems.php
        $destination_path = "trainingProgramms"; // path relative to the disk above

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
