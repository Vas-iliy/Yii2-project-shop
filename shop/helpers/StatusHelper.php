<?php

namespace shop\helpers;

use yii\helpers\ArrayHelper;

class StatusHelper
{
    public static function staticList()
    {
        return [
            false => 'Deleted',
            true => 'Published',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::staticList(), $status);
    }
}