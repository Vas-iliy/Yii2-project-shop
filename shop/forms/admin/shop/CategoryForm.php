<?php

namespace shop\forms\admin\shop;

use shop\entities\shop\Category;
use shop\forms\CompositeForm;
use shop\forms\admin\MetaForm;

class CategoryForm extends CompositeForm
{
    public $name;
    public $title;
    public $description;
    public $parentId;
    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parentId'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['name'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null],
        ];
    }

    protected function internalForms()
    {
        return ['meta'];
    }
}