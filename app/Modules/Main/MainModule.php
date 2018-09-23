<?php
/**
 * Created by PhpStorm.
 * User: nightracer
 * Date: 22.09.2018
 * Time: 14:20
 */

namespace Modules\Main;


use Simff\Module\Module;

class MainModule extends Module
{
    public static function getRoutes()
    {
        return [
            [
                'route' => '/',
                'target' => [\Modules\Main\Controllers\MainController::class, 'index'],
                'name' => 'index',
            ],
            [
                'route' => '/login',
                'target' => [\Modules\Main\Controllers\AuthController::class, 'login'],
                'name' => 'login'
            ],
            [
                'route' => '/logout',
                'target' => [\Modules\Main\Controllers\AuthController::class, 'logout'],
                'name' => 'logout'
            ],
            [
                'route' => '/edit/{id}',
                'constraints' => [
                    'id' => '\d+'
                ],
                'target' => [\Modules\Main\Controllers\MainController::class, 'edit'],
                'name' => 'edit'
            ]
        ];
    }
}