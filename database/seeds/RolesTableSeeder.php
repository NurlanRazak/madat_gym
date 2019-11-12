<?php

use Illuminate\Database\Seeder;
use App\Services\MenuService\Models\Role;
use App\Services\MenuService\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'superadmin' => Permission::all()->pluck('name'),
            'manager' => [],
            'developer' => Permission::all()->pluck('name')
        ];

        foreach($roles as $role=>$permissions) {
            Role::firstOrCreate([
                'name' => $role,
                'key' => $role,
            ])
            ->givePermissionTo($permissions);
        }
    }
}
