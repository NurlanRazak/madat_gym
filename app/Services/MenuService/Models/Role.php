<?php

namespace App\Services\MenuService\Models;

use Backpack\PermissionManager\app\Models\Role as OriginalRole;
use App\Services\MenuService\Exceptions\RoleDoesNotExistException;

class Role extends OriginalRole
{
    protected $fillable = ['name', 'key', 'guard_name', 'updated_at', 'created_at'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function getNameByKey(string $key) : string
    {
        $role = self::select('name')->where('key', $key)->first();

        if (!$role)
        {
            throw new RoleDoesNotExistException($key);
        }
        return $role->name;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
