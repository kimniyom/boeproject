<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Masreport */

$this->title = 'Update Masreport: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Masreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reportid, 'url' => ['view', 'id' => $model->reportid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masreport-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
