<?php

namespace forms\admin\shop;

use entities\shop\Category;
use entities\shop\Characteristic;
use forms\CompositeForm;
use forms\admin\MetaForm;
use yii\base\Model;

class CharacteristicForm extends Model
{
    public $name;
    public $type;
    public $request;
    public $default;
    public $textVariants;
    public $sort;

    private $_characteristic;

    public function __construct(Characteristic $characteristic = null, $config = [])
    {
        if ($characteristic) {
            $this->name = $characteristic->name;
            $this->type = $characteristic->type;
            $this->request = $characteristic->request;
            $this->default = $characteristic->default;
            $this->textVariants = implode(PHP_EOL, $characteristic->variants);
            $this->sort = $characteristic->sort;
            $this->_characteristic = $characteristic;
        } else {
            $this->sort = Characteristic::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'type', 'sort'], 'required'],
            [['request'], 'boolean'],
            [['default'], 'string', 'max' => 255],
            [['textVariants'], 'string'],
            [['sort'], 'integer'],
            [['name'], 'unique', 'targetClass' => Characteristic::class, 'filter' => $this->_characteristic ? ['<>', 'id', $this->_characteristic->id] : null],
        ];
    }

    public function getVariants()
    {
        return preg_split('/[\r\n]+/i', $this->textVariants);
    }
}