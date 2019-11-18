<?php

namespace App\Services\MenuService\Traits;

trait MenuTrait
{

    private static function getMenuItems() : array
    {
        return [
            [
                'route'         => backpack_url('dashboard'),
                'icon'          => 'fa fa-dashboard',
                'label'         => trans('backpack::base.dashboard'),
            ],
            [
                'route'         => '#',
                'icon'          => 'fa fa-thumb-tack',
                'label'         => 'Тренировки',
                'sub_items'     => [
                    [
                        'route'         => backpack_url('subscription'),
                        'icon'          => 'fa fa-ticket',
                        'label'         => trans_choice('admin.subscription', 2),
                        'permissions'   => [
                            'Subscription' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('programtraining'),
                        'icon'          => 'fa fa-thumb-tack',
                        'label'         => 'Программы (тренировки)',
                        'permissions'   => [
                            'Programtraining' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('programtype'),
                        'icon'          => 'fa fa-tasks',
                        'label'         => 'Типы программ',
                        'permissions'   => [
                            'Programtype' => 'view',
                        ],
                    ],
                    [
                        'route'        => backpack_url('activeprogram'),
                        'icon'         => 'fa fa-toggle-on',
                        'label'        => 'Активные программы',
                        'permissions'  => [
                            'Activeprogram' => 'view',
                        ],
                    ],
                    [
                        'route'        => backpack_url('exercise'),
                        'icon'         => 'fa fa-sign-language',
                        'label'        => 'Упражнения',
                        'permissions'  => [
                            'Exercise' => 'view',
                        ],
                    ],
                    [
                        'route'        => backpack_url('training'),
                        'icon'         => 'fa fa-bicycle',
                        'label'        => 'Тренировки (программы-упражнения)',
                        'permissions'  => [
                            'Training' => 'view',
                        ],
                    ],
                    [
                        'route'        => backpack_url('listequip'),
                        'icon'         => 'fa fa-tasks',
                        'label'        => 'Список Оборудования',
                        'permissions'  => [
                            'Equipment' => 'view',
                        ],
                    ],
                    [
                        'route'        => backpack_url('equipment'),
                        'icon'         => 'fa fa-gavel',
                        'label'        => 'Оборудование для тренировок',
                        'permissions'  => [
                            'Equipment' => 'view',
                        ],
                    ],
                    [
                        'route'        => backpack_url('grocery'),
                        'icon'         => 'fa fa-shopping-basket',
                        'label'        => 'Продукты для тренировок',
                        'permissions'  => [
                            'Grocery' => 'view',
                        ],
                    ],
                ],
            ],
            [
                'route'         => '#',
                'icon'          => 'fa fa-balance-scale',
                'label'         => 'Питание',
                'sub_items'     => [
                    [
                        'route'         => backpack_url('foodprogram'),
                        'icon'          => 'fa fa-cutlery',
                        'label'         => 'Программы питания',
                        'permissions'   => [
                            'Foodprogram' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('meal'),
                        'icon'          => 'fa fa-leaf',
                        'label'         => 'Блюда',
                        'permissions'   => [
                            'Meal' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('eathour'),
                        'icon'          => 'fa fa-hourglass-half',
                        'label'         => 'Часы приема',
                        'permissions'   => [
                            'Eathour' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('planeat'),
                        'icon'          => 'fa fa-calendar-plus-o',
                        'label'         => 'План питания',
                        'permissions'   => [
                            'Planeat' => 'view',
                        ],
                    ],
                ],
            ],
            [
                'route'         => '#',
                'icon'          => 'fa fa-bed',
                'label'         => 'Отдых',
                'sub_items'     => [
                    [
                        'route'         => backpack_url('relaxprogram'),
                        'icon'          => 'fa fa-bell',
                        'label'         => 'Программы отдыха',
                        'permissions'   => [
                            'Relaxprogram' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('relaxexercise'),
                        'icon'          => 'fa fa-recycle',
                        'label'         => 'Упражнения',
                        'permissions'   => [
                            'Relaxexercise' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('relaxtraining'),
                        'icon'          => 'fa fa-bicycle',
                        'label'         => 'Тренировки (программы-упражнения)',
                        'permissions'   => [
                            'Relaxtraining' => 'view',
                        ],
                    ],
                ],
            ],
            [
                'route'         => '#',
                'icon'          => 'fa fa-group',
                'label'         => 'Люди',
                'sub_items'     => [
                    [
                        'route'         => backpack_url('consumer'),
                        'icon'          => 'fa fa-user',
                        'label'         => 'Пользователи',
                        'permissions'   => [
                            'User' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('userparameter'),
                        'icon'          => 'fa fa-user',
                        'label'         => 'Параметры Пользователя',
                        'permissions'   => [
                            'User' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('user'),
                        'icon'          => 'fa fa-user',
                        'label'         => 'Сотрудники',
                        'permissions'   => [
                            'BackpackUser' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('role'),
                        'icon'          => 'fa fa-group',
                        'label'         => 'Роли',
                        'permissions'   => [
                            'Role' => 'view',
                        ],
                    ],
                    [
                        'route'         => backpack_url('permission'),
                        'icon'          => 'fa fa-key',
                        'label'         => 'Уровни разрешения',
                        'permissions'   => [
                            'Permission' => 'view',
                        ],
                    ],
                ],
            ],
            [
                'route' => backpack_url('message'),
                'icon' => 'fa fa-envelope',
                'label' => 'Сообщения',
                'permissions' => [
                    'Message' => 'view',
                ],
            ],
            [
                'route' => '#',
                'icon' => 'fa fa-shopping-cart',
                'label' => 'Покупки',
                'sub_items' => [
                    [
                        'route' => backpack_url('typepurchase'),
                        'icon' => 'fa fa-shopping-bag',
                        'label' => 'Типы покупок',
                        'permissions' => [
                            'Typepurchase' => 'view',
                        ],
                    ],
                    [
                        'route' => backpack_url('purchase'),
                        'icon' => 'fa fa-dollar',
                        'label' => 'Покупки',
                        'permissions' => [
                            'Purchase' => 'view',
                        ],
                    ],
                ],
            ],
            [
                'route'         => backpack_url('elfinder'),
                'icon'          => 'fa fa-files-o',
                'label'         => trans('backpack::crud.file_manager'),
                'roles'         => [
                    'manager', 'superadmin'
                ],
            ],
        ];
    }


}
