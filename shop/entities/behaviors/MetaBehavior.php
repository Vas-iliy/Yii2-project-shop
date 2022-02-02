<?php

namespace entities\behaviors;

use entities\Meta;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class MetaBehavior extends Behavior
{
    public $attribute = 'meta';
    public $jsonAttribute = 'meta_json';
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event)
    {
        $brand = $event->sender;
        $meta = Json::decode($brand->getAttribute($this->jsonAttribute));
        $brand->{$this->attribute} = new Meta($meta['title'] ?? null, $meta['description'] ?? null, $meta['keywords'] ?? null);
    }

    public function onBeforeSave(Event $event)
    {
        $brand = $event->sender;
        $brand->setAttribute($this->jsonAttribute, Json::encode([
            'title' => $brand->{$this->attribute}->title,
            'description' => $brand->{$this->attribute}->description,
            'keywords' => $brand->{$this->attribute}->keywords,
        ]));
    }
}