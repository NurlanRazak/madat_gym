<?php

namespace App\Services\MenuService\Models;

use Backpack\PermissionManager\app\Models\Permission as OriginalPermission;
use App\Services\MenuService\Exceptions\PermissionDoesNotExistException;
use App\Services\MenuService\Exceptions\DuplicatePermissionException;

class Permission extends OriginalPermission
{

    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at', 'action', 'model'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

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

    public static function getNamesByModelAndAction(string $model, string $action) : string
    {
        $model = trim($model);
        $action = trim($action);

        $names = self::select('name')->where('model', $model)->where('action', $action)->get()->pluck('name')->toArray();
        switch(count($names)) {
            case 0:
                throw new PermissionDoesNotExistException($action, $model);
            case 1:
                return $names[0];
            default:
                throw new DuplicatePermissionException($action, $model, $names);
        }
    }

    public static function getNamesByModelAndActions(string $model, $actions) : array
    {
        $names = [];
        $actions = is_string($actions) ? explode(',', $actions) : $actions;

        foreach($actions as $action)
        {
            $names[]= self::getNamesByModelAndAction($model, $action);
        }
        return $names;
    }

    public static function getNamesByModelsAndAction($models, string $action) : array
    {
        $names = [];
        $models = is_string($models) ? explode(',', $models) : $models;

        foreach($models as $model)
        {
            $names[]= self::getNamesByModelAndAction($model, $action);
        }
        return $names;
    }
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
