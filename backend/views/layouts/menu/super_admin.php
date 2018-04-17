<?php
return [
//    ['label' => 'Menu ', 'options' => ['class' => 'header']],
    ['label' => 'Data', 'icon' => 'users', 'url' => ['/site'],],
//                    ['label' => 'Forms', 'icon' => 'wpforms', 'url' => ['/forms'],],
//                    ['label' => 'Create Form', 'icon' => 'file-code-o', 'url' => ['/form'],],
    [
        'label' => 'Admin Users',
        'icon' => 'user-o',
        'url' => '#',
        'items' => [
            ['label' => 'Admin Users', 'icon' => 'users', 'url' => ['/users'],],
            ['label' => 'Create User', 'icon' => 'user-plus', 'url' => ['/users/create'],],
            ['label' => 'Users Forms', 'icon' => 'address-card', 'url' => ['/users/user-form'],],
        ],
    ],
    [
        'label' => 'Forms',
        'icon' => 'wpforms',
        'url' => '#',
        'items' => [
            ['label' => 'Forms', 'icon' => 'users', 'url' => ['/forms'],],
            ['label' => 'Create new', 'icon' => 'file-code-o', 'url' => ['/form'],],
        ],
    ],
//    [
//        'label' => 'Users Data',
//        'icon' => 'wpforms',
//        'url' => '#',
//        'items' => [
//            ['label' => 'Forms', 'icon' => 'users', 'url' => ['/users-form'],],
////                            ['label' => 'Create Forms', 'icon' => 'file-code-o', 'url' => ['/form'],],
//        ],
//    ],
//                    [
//                        'label' => 'new',
//                        'icon' => 'user-o',
//                        'url' =>  ['/users'],
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'user-plus', 'url' => ['/gii'],],
//
//                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
];