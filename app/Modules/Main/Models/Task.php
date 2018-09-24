<?php

namespace Modules\Main\Models;


use Simff\Model\Fields\BooleanField;
use Simff\Model\Fields\CharField;
use Simff\Model\Fields\EmailField;
use Simff\Model\Fields\ImageField;
use Simff\Model\Fields\TextField;
use Simff\Model\Model;

class Task extends Model
{
    public static function getFields()
    {
        return [
            'name' => [
                'class' => CharField::class,
                'required' => true,
                'placeholder' => 'Имя'
            ],
            'email' => [
                'class' => EmailField::class,
                'required' => true,
                'placeholder' => 'Email'
            ],
            'text' => [
                'class' => TextField::class,
                'required' => true,
                'placeholder' => 'Текст задачи'
            ],
            'image' => [
                'class' => ImageField::class,
                'maxSizes' => [320, 240]
            ],
            'done' => [
                'class' => BooleanField::class,
                'default' => 0
            ]
        ];
    }

    public static function filtered()
    {
        $sql = "SELECT * FROM " . static::getTableName();
        $enableSort = ['ASC', 'DESC'];
        $sorted = false;

        $sortName = isset($_GET['sort_name']) ? $_GET['sort_name'] : null;
        $sortEmail = isset($_GET['sort_email']) ? $_GET['sort_email'] : null;

        $params = [];


        if (isset($_GET['filter_status'])) {

            $filterStatus = $_GET['filter_status'];

            if ($filterStatus != 'all') {

                $sql .= " WHERE done = :status";
                $params['status'] = $filterStatus;
            }
        }

        if (in_array($sortName, $enableSort) || in_array($sortEmail, $enableSort)) {
            $sql .= " ORDER BY ";

            if (in_array($sortName, $enableSort)) {
                $sql .= "name $sortName";
                $sorted = true;
            }

            if (in_array($sortEmail, $enableSort)) {
                if ($sorted) {
                    $sql .= ", ";
                }
                $sql .= "email $sortEmail";
            }
        }


        $data = self::connection()->query($sql)->resultSet($params);

        return self::initModels($data);
    }
}