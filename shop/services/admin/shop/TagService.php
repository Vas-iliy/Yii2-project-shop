<?php

namespace shop\services\admin\shop;

use shop\entities\shop\Tag;
use shop\forms\admin\shop\TagForm;
use shop\repositories\shop\TagRepository;
use yii\helpers\Inflector;

class TagService
{
    private $tags;

    public function __construct()
    {
        $this->tags = new TagRepository();
    }

    public function create(TagForm $form)
    {
        $tag = Tag::create($form->name, Inflector::slug($form->name));
        $this->tags->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form)
    {
        $tag = $this->tags->get($id);
        $tag->edit($form->name, Inflector::slug($form->name));
        $this->tags->save($tag);
    }

    public function remove($id)
    {
        $tag = $this->tags->get($id);
        $this->tags->remove($tag);
    }
}