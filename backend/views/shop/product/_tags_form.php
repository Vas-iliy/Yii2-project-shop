<?php use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>
<div class="box box-default">
    <div class="box-header with-border">Tags</div>
    <div class="box-body">
        <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList()) ?>
        <?= $form->field($model->tags, 'textNew')->textInput() ?>
    </div>
</div>
<?ActiveForm::end()?>