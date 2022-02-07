<?php

namespace shop\helpers;

use shop\entities\shop\Characteristic;
use yii\helpers\ArrayHelper;

class CharacteristicHelper
{
    public static function typeList()
    {
        return [
            Characteristic::TYPE_STRING => 'String',
            Characteristic::TYPE_INTEGER => 'Integer',
            Characteristic::TYPE_FLOAT => 'Float number',
        ];
    }

    public static function typeName($type)
    {
        return ArrayHelper::getValue(self::typeList(), $type);
    }
}