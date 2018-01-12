<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Masreport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="masreport-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reportname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->radioList(['0' => 'ใม่ใช้งาน','1' => 'ใช้งาน'],['value' => '1']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
