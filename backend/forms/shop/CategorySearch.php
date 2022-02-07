<?php

namespace backend\forms\shop;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\entities\shop\Category;

class CategorySearch extends Model
{
    public $id;
    public $name;
    public $alias;
    public $title;
    public $status;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'alias', 'title'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Category::find()->andWhere(['>', 'depth', 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['lft' => SORT_ASC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
