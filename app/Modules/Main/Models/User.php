<?php

namespace Modules\Main\Models;


use Simff\Model\Fields\BooleanField;
use Simff\Model\Fields\CharField;
use Simff\Model\Fields\EmailField;
use Simff\Model\Fields\PasswordField;
use Simff\Model\Model;

class User extends Model
{
    public $is_guest = false;

    public static function getFields()
    {
        return [
            'login' => [
                'class' => CharField::class,
                'placeholder' => 'Логин'
            ],
            'email' => [
                'class' => EmailField::class,
                'placeholder' => 'Email'
            ],
            'name' => [
                'class' => CharField::class,
                'placeholder' => 'Имя'
            ],
            'password' => [
                'class' => PasswordField::class,
                'placeholder' => 'Пароль'
            ],
            'is_admin' => [
                'class' => BooleanField::class
            ]
        ];
    }

    public function getIsGuest()
    {
        return $this->is_guest;
    }

    public function getIsAdmin()
    {
        return !$this->getIsGuest() && $this->is_admin;
    }
}