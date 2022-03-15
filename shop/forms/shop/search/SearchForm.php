<?php

namespace shop\forms\shop\search;

use shop\entities\shop\Brand;
use shop\entities\shop\Category;
use shop\entities\shop\Characteristic;
use shop\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * @property ValueForm[] $values
 */
class SearchForm extends CompositeForm
{
    public $text;
    public $category;
    public $brand;

    public function __construct($config = [])
    {
        $this->values = array_map(function (Characteristic $characteristic) {
            return new ValueForm($characteristic);
        }, Characteristic::find()->orderBy('sort')->all());
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['text'], 'string'],
            [['category', 'brand'], 'integer'],
        ];
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }

    public function brandsList(): array
    {
        return ArrayHelper::map(Brand::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function formName(): string
    {
        return '';
    }

    protected function internalForms(): array
    {
        return ['values'];
    }
}