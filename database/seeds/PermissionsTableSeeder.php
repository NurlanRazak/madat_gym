<?php

use Illuminate\Database\Seeder;
use App\Services\MenuService\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crud = ['update', 'view'];
        $classes = [
            'User', 'BackpackUser', 'Role', 'Permission',
            'Activeprogram', 'Eathour', 'Equipment', 'Exercise', 'Foodprogram',
            'Grocery', 'Meal', 'Message', 'Planeat', 'Programtraining',
            'Programtype', 'Relaxexercise', 'Relaxprogram', 'Relaxtraining',
            'Subscription', 'Training', 'Purchase', 'Typepurchase'
        ];

        foreach($classes as $class) {
            foreach($crud as $action) {
                Permission::firstOrCreate([
                    'name'      => "{$action} {$class}",
                    'action'    => $action,
                    'model'     => $class
                ]);
            }
        }
    }
}
