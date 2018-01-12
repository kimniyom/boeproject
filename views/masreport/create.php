<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Masreport */

$this->title = 'สร้างแบบฟอร์ม';
$this->params['breadcrumbs'][] = ['label' => 'Masreports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masreport-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
