<?php

namespace shop\entities\user;

use Webmozart\Assert\Assert;
use yii\db\ActiveRecord;

class Network extends ActiveRecord
{
    public static function create($network, $identity)
    {
        Assert::notEmpty($network);
        Assert::notEmpty($identity);

        $item = new static();
        $item->network = $network;
        $item->identity = $identity;
        return $item;
    }

    public static function tableName()
    {
        return '{{user_networks}}';
    }

    public function isFor($network, $identity)
    {
        return $this->network === $network && $this->identity === $identity;
    }
}