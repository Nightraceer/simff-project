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
        $filterName = null;
        $filterStatus = null;
        $params = [];

        if (isset($_GET['filter_name_or_email']) && $filterName = $_GET['filter_name_or_email']) {

            $sql .= " WHERE (name LIKE :filter_name OR email LIKE :filter_email)";

            $filterName = '%'.$filterName.'%';

            $params['filter_name'] = $filterName;
            $params['filter_email'] = $filterName;
        }


        if (isset($_GET['filter_status'])) {

            $filterStatus = $_GET['filter_status'];

            if ($filterStatus != 'all') {

                if ($filterName) {
                    $sql .= " AND";
                } else {
                    $sql .= " WHERE";
                }

                $sql .= " done = :status";
                $params['status'] = $filterStatus;
            }
        }


        $data = self::connection()->query($sql)->resultSet($params);

        return self::initModels($data);
    }
}