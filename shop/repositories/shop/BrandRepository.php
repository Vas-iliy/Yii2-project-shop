<?php


namespace repositories\shop;


use entities\shop\Brand;
use yii\web\NotFoundHttpException;

class BrandRepository
{
    public function get($id)
    {
        if (!$tag = Brand::findOne($id)) throw new NotFoundHttpException('Tag is not found.');
        return $tag;
    }

    public function save(Brand $tag)
    {
        if (!$tag->save()) throw new \RuntimeException('Saving error.');
    }

    public function remove(Brand $tag)
    {
        if (!$tag->delete()) throw new \RuntimeException('Removing error.');
    }
}