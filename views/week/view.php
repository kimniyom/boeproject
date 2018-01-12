<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Web;

/* @var $this yii\web\View */
/* @var $model app\models\Week */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Weeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <div class="panel panel-default">
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'ปี พ.ศ.',
                'value' => function ($data) {
                    return ($data->year + 543);
                },
            ],
            [
                'label' => 'เดือน',
                'value' => function ($data) {
                    return \app\models\Month::findOne(["id" => $data->month])['month_th'];
                },
            ],
            [
                'label' => 'วันที่เริ่มต้น',
                'value' => function ($data) {
                    $Web = new Web();
                    return $Web->thaidate($data->datestart);
                },
            ],
            [
                'label' => 'วันที่สิ้นสุด',
                'value' => function ($data) {
                    $Web = new Web();
                    return $Web->thaidate($data->dateend);
                },
            ],
            'week',
        ],
    ])
    ?>
    </div>
</div>
