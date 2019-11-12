<?php

namespace App\Services\MenuService;

use App\Models\BackpackUser;
use App\Services\MenuService\Models\Permission;
use App\Services\MenuService\Models\Role;
use App\Services\MenuService\Traits\MenuTrait;

class AdminMenuGenerator
{
    use MenuTrait;

    public static function getTree() : array
    {
        $menu_items = [];
        foreach(self::getMenuItems() as $menu_item)
        {
            $menu_items[]= self::getMenuItem($menu_item);
        }
        return array_filter($menu_items);
    }

    private static function getMenuItem(array $menu_item)
    {
        if (isset($menu_item['sub_items']))
        {
            $sub_items = [];
            foreach($menu_item['sub_items'] as $sub_item)
            {
                $sub_items[]= self::getMenuItem($sub_item);
            }
            $menu_item['sub_items'] = array_filter($sub_items);
            if (count($menu_item['sub_items']) == 0)
                return null;
            if (count($menu_item['sub_items']) == 1)
                $menu_item = array_values($menu_item['sub_items'])[0];
        }
        return self::checkPermissions(self::getPermissions($menu_item['permissions'] ?? []), self::getRoles($menu_item['roles'] ?? [])) ? $menu_item : null;
    }

    private static function checkPermissions(array $permissions, array $roles) : bool
    {
        $user = backpack_user();
        $ans = true;
        if (count($permissions))
            $ans &= $user->hasAllPermissions($permissions);
        if (count($roles))
            $ans &= $user->hasAllRoles($roles);
        return $ans;
    }

    private static function getPermissions(array $permissions) : array
    {
        $permission_names = [];
        foreach($permissions as $model => $actions)
        {
            $permission_names = array_merge($permission_names, Permission::getNamesByModelAndActions($model, $actions));
        }
        return $permission_names;
    }

    private static function getRoles(array $roles) : array
    {
        $role_names = [];
        foreach($roles as $role)
        {
            $role_names[]= Role::getNameByKey($role);
        }
        return $role_names;
    }

}
