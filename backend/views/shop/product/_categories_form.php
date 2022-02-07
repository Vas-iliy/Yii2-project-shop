<?php use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>
<div class="box box-default">
    <div class="box-header with-border">Categories</div>
    <div class="box-body">
        <?= $form->field($model->categories, 'main')->dropDownList($list = $model->categories->categoriesList(), ['prompt' => '']) ?>
        <?= $form->field($model->categories, 'others')->checkboxList($list) ?>
    </div>
</div>
<?ActiveForm::end()?>