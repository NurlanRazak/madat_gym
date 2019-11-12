<?php

namespace App\Services\MenuService\Traits;

use App\Services\MenuService\Exceptions\InvalidAccessLevelTraitTraitUsageException;
use App\Services\MenuService\Models\Permission;

trait AccessLevelsTrait
{
    private $actions = [
        'list' => ['view', 'create', 'update', 'delete'],
        'create' => ['create'],
        'update' => ['update'],
        'delete' => ['delete'],
        'revisions' => ['update', 'delete'],
        // 'reorder' => ['create', 'update'],
        'show' => ['view', 'create', 'update', 'delete'],
        // 'clone' => ['create'],
    ];

    private function setAccessLevels()
    {

        if (!$this->crud)
        {
            throw new InvalidAccessLevelTraitTraitUsageException(self::class);
        }

        $user = backpack_user();

        foreach($this->actions as $access => $actions)
        {
            $permissions = $this->getPermissions($actions);

            if ($user->hasAnyPermission($permissions))
                $this->crud->allowAccess($access);
            else
                $this->crud->denyAccess($access);
        }
    }

    private function getPermissions(array $actions) : array
    {
        return Permission::getNamesByModelAndActions(class_basename($this->crud->model), $actions);
    }

}
