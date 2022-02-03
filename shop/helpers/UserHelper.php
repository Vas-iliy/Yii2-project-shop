<?php

namespace shop\helpers;

use shop\entities\user\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    public static function staticList()
    {
        return [
            User::STATUS_ACTIVE => 'Active',
            User::STATUS_DELETED => 'Delete',
            User::STATUS_INACTIVE => 'Wait',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::staticList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            case User::STATUS_INACTIVE:
                $class = 'label label-default';
                break;
            case User::STATUS_DELETED:
                $class = 'label label-danger';
        }

        return Html::tag('span', ArrayHelper::getValue(self::staticList(), $status), [
            'class' => $class,
        ]);
    }
}