<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Web;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WeekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Weeks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Create Week', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="panel panel-default">
        <div class="panel-body">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'year',
                    'format' => 'raw',
                    'value' => function($data) {
                        return ($data->year + 543);
                    }
                ],
                [
                    'attribute' => 'month',
                    'format' => 'raw',
                    'value' => function($data) {
                        return \app\models\Month::findOne(["id" => $data->month])['month_th'];
                    }
                ],
                [
                    'attribute' => 'datestart',
                    'format' => 'raw',
                    'value' => function($data) {
                        $Web = new Web();
                        return $Web->thaidate($data->datestart);
                    }
                ],
                [
                    'attribute' => 'dateend',
                    'format' => 'raw',
                    'value' => function($data) {
                        $Web = new Web();
                        return $Web->thaidate($data->dateend);
                    }
                ],
                'week',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
        </div>
    </div>
</div>
