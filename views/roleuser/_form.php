<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Groupprivilege;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Roleuser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roleuser-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo $form->field($model, 'group_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Groupprivilege::find()->all(),'groupcode','groupname'),
        'language' => 'th',
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>
<?= $form->field($model, 'user_id')->hiddenInput(['maxlength' => true, 'value' => $userid, 'readonly' => 'readonly'])->label(false) ?>

    <div class="form-group">
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
