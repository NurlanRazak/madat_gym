<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Str;

class Relaxexercise extends Model
{
    use CrudTrait;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'relaxexercises';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'short_description', 'long_description', 'image', 'video', 'audio', 'active'];
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
    public function relaxtrainings()
    {
        return $this->belongsToMany(Relaxtraining::class, 'relaxtrainings_relaxexercises', 'exercise_id', 'relaxtraining_id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getVideoKeyAttribute()
    {
        try {
			list($key, $name) = explode(':', $this->video);
		} catch(\Exception $e) {
			return null;
		}
        return $key;
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
        $destination_path = "relaxexercises/images"; // path relative to the disk above

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


    public function setAudioAttribute($value)
    {
        $attribute_name = "audio";
        $disk = 'uploads';
        $destination_path = "exercises/audio";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }

    public function toCalendar()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

}
