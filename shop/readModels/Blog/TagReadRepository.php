<?php

namespace shop\readModels\Blog;


use shop\entities\shop\Tag;

class TagReadRepository
{
    public function find($id)
    {
        return Tag::findOne($id);
    }
}