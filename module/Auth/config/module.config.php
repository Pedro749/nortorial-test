<?php

namespace Auth;

use Zend\Router\Http\Literal;
use Zend\Authentication\AuthenticationService;
use Auth\Controller\Factory\IndexControllerFactory;
use Auth\Authentication\Factory\AuthenticationFactory;

return [
    'router' => [
        'routes' => [
            'auth.login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'auth.logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'logout'
                    ]
                ]
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            AuthenticationService::class => AuthenticationFactory::class
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => IndexControllerFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'auth/index/login' => __DIR__ . '/../view/auth/index/login.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ]
    ]
];
