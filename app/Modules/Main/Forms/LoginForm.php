<?php

namespace Modules\Main\Forms;

use Modules\Main\Helpers\Password;
use Modules\Main\Models\User;
use Simff\Form\Form;
use Simff\Main\Simff;

class LoginForm extends Form
{
    public function validate()
    {
        $state = true;
        $loginField = $this->getField('login');
        $passwordField = $this->getField('password');

        $hasher = Password::class;

        $user = $this->getUser($loginField->getValue());

        if ($user) {
            if (!$hasher::verify($passwordField->getValue(), $user->password)) {
                $state = false;
                $this->addError('password', 'Некорректный пароль');
            }
        } else {
            $state = false;
            $this->addError('login', 'Пользователь с таким именем не зарегистрирован');
        }

        if ($state) {
            $this->login($user);
        }

        return $state;
    }

    public function save()
    {
        return true;
    }

    public function login($user)
    {
        if ($user) {
            Simff::app()->auth->login($user);
        }
    }

    public function getUser($login)
    {
        return User::getOnAttribute('login', $login);
    }
}