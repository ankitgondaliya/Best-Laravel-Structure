<?php

return [
    'SIDEBAR' => [
        'Dashboard' => [
            'route' => 'admin.dashboard',
            'iconClass' => 'fas fa-tachometer-alt',
        ],
        'Profile' => [
            'route' => 'admin.profile',
            'iconClass' => 'fas fa-user',
        ],
        'Users' => [
            'route' => 'users.index',
            'iconClass' => 'fas fa-users',
        ],
        'Static Pages' => [
            'Terms and Conditions' => [
                'route' => 'admin.static-page',
                'iconClass' => 'fa fa-file-contract',
                'param' => ['slug' => 'terms-and-conditions'],
            ],
            'Privacy Policy' => [
                'route' => 'admin.static-page',
                'iconClass' => 'fa fa-lock',
				'param' => ['slug' => 'privacy-policy'],
            ],
        ],

    ],
];
