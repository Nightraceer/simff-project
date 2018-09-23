<?php

namespace Modules\Main\Controllers;


use Modules\Main\Forms\LoginForm;
use Modules\Main\Models\User;
use Simff\Controller\Controller;
use Simff\Main\Simff;

class AuthController extends Controller
{
    public function loginAction()
    {
        $user = Simff::app()->getUser();

        if (!$user->getIsGuest()) {
            Simff::app()->request->redirect("Main.index");
        }

        $form = new LoginForm(User::class);
        $form->exclude = ['name', 'is_admin', 'email'];

        $this->ajaxValidation($form, '/');

        echo $this->render("login/index.tpl", [
            'form' => $form,
            'user' => $user
        ]);
    }

    public function logoutAction()
    {
        Simff::app()->auth->logout();
        Simff::app()->request->redirect('Main.login');
    }
}