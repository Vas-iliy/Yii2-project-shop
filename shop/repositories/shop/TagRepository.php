<?php


namespace repositories\shop;


use entities\shop\Tag;
use yii\web\NotFoundHttpException;

class TagRepository
{
    public function get($id)
    {
        if (!$tag = Tag::findOne($id)) throw new NotFoundHttpException('Tag is not found.');
        return $tag;
    }

    public function save(Tag $tag)
    {
        if (!$tag->save()) throw new \RuntimeException('Saving error.');
    }

    public function remove(Tag $tag)
    {
        if (!$tag->delete()) throw new \RuntimeException('Removing error.');
    }
}