<?php

namespace backend\forms\shop;

use shop\helpers\CharacteristicHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\Characteristic;

class CharacteristicSearch extends Model
{
    public $id;
    public $name;
    public $required;
    public $type;
    public $status;


    public function rules()
    {
        return [
            [['id', 'type', 'required', 'status'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Characteristic::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'required' => $this->required,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function typesList(): array
    {
        return CharacteristicHelper::typeList();
    }

    public function requiredList(): array
    {
        return [
            1 => \Yii::$app->formatter->asBoolean(true),
            0 => \Yii::$app->formatter->asBoolean(false),
        ];
    }
}
