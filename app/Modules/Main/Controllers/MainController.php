<?php

namespace Modules\Main\Controllers;


use Modules\Main\Forms\LoginForm;
use Modules\Main\Helpers\Password;
use Modules\Main\Models\Task;
use Modules\Main\Models\User;
use Simff\Controller\Controller;
use Simff\Form\Form;
use Simff\Main\Simff;
use Simff\Pagination\Pagination;

class MainController extends Controller
{
    public function indexAction()
    {
        $user = Simff::app()->getUser();

        $tasks = Task::filtered();

        $form = new Form(Task::class);
        $form->exclude[] = 'done';

        $this->ajaxValidation($form);

        $pager = new Pagination([
            'pageSize' => 3,
            'source' => $tasks
        ]);


        echo $this->render("index/index.tpl", [
            'pager' => $pager,
            'form' => $form,
            'user' => $user
        ]);
    }

    public function editAction($id)
    {
        $task = Task::get($id);
        $data = ['state' => 'Не сохранено'];

        if ($task) {
            if (isset($_POST['text']) && $text = $_POST['text']) {
                $task->text = $text;
            }
            if (isset($_POST['done'])) {
                $task->done = $_POST['done'];
            }

            if ($task->save()) {
                $data = ['state' => 'Сохранено'];
            }
        }

        $this->jsonResponse($data);
    }

    public function previewAction()
    {
        if (!Simff::app()->request->getIsAjax()) {
            $this->error(404);
        }

        $form = new Form(Task::class);
        $form->fill($_GET);


        echo $this->render("preview/index.tpl", [
            'form' => $form
        ]);
    }
}