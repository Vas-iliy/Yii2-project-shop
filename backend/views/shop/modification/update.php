<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\entities\shop\product\Modification */

$this->title = 'Update Modification: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Modifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
