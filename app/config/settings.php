<?php

return [
    'paths' => [
        'app' => realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..'])),
        'public' => realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', '..', 'public'])),
    ],
    'modules' => [
        'Base',
        'Main'
    ],
    'components' => [
        'db' => [
            'class' => \Simff\Db\Connection::class,
            'host' => '127.0.0.1',
            'database' => 'ialexgpp_tony_bd',
            'username' => 'ialexgpp_tony_bd',
            'password' => '%QYOrAL4',
            'charset' => 'utf8', // Optional
        ],
        'errorHandler' => [

        ],
        'auth' => [
            'class' => \Modules\Main\Components\Auth::class
        ],
        'request' => [
            'class' => \Simff\Request\HttpRequest::class,
            'session' => [
                'class' => \Simff\Helpers\Session::class
            ]
        ],
        'router' => [
            'class' => \Simff\Router\Router::class,
        ],
        'template' => [
            'class' => \Simff\Template\TemplateManager::class,
            'forceCompile' => DEBUG ? true : false,
            'autoReload' => DEBUG ? true : false
        ],

    ],
];