<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Month;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Week */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="week-form">
    <div class="panel panel-default">
        <?php $form = ActiveForm::begin(); ?>
        <div class="panel-body">
             <div class="row">
                <div class="col-md-3 col-lg-3">
                    <?php
                    $yearnow = date("Y");
                    $yearnext = ($yearnow + 1);
                    $YearArr = array($yearnext => $yearnext + 543, $yearnow => $yearnow + 543);
                    echo $form->field($model, 'year')->widget(Select2::classname(), [
                        'data' => $YearArr,
                        'language' => 'th',
                        'options' => ['placeholder' => 'ปี ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-lg-3">
                    <?php
                    echo $form->field($model, 'month')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Month::find()->all(), 'id', 'month_th'),
                        'language' => 'th',
                        'options' => ['placeholder' => 'เดือน ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-3 col-lg-3">
                    <?php
                    echo $form->field($model, 'week')->widget(Select2::classname(), [
                        'data' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4'],
                        'language' => 'th',
                        'options' => ['placeholder' => 'สัปดาห์ ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <?php
                    echo $form->field($model, 'datestart')->widget(DatePicker::classname(), [
                        //'value' => date('Y-m-d'),
                        'options' => ['placeholder' => 'Select issue date ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-d',
                            'todayHighlight' => true
                        ]
                    ]);
                    ?>
                </div>

                <div class="col-md-3 col-lg-3">
                    <?php
                    echo $form->field($model, 'dateend')->widget(DatePicker::classname(), [
                        //'value' => date('Y-m-d'),
                        'options' => ['placeholder' => 'Select issue date ...'],
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-d',
                            'todayHighlight' => true
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        </div>

        
    </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
