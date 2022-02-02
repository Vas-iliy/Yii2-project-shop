<?php


namespace repositories\shop;

use entities\shop\Category;
use entities\shop\Characteristic;
use yii\web\NotFoundHttpException;

class CharacteristicRepository
{
    public function get($id)
    {
        if (!$characteristic = Characteristic::findOne($id)) throw new NotFoundHttpException('Tag is not found.');
        return $characteristic;
    }

    public function save(Characteristic $characteristic)
    {
        if (!$characteristic->save()) throw new \RuntimeException('Saving error.');
    }

    public function remove(Characteristic $characteristic)
    {
        $characteristic->status = '0';
        if (!$characteristic->save()) throw new \RuntimeException('Removing error.');
    }
}