<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Roleuser */

$this->title = 'แก้ไขสิทธิ์';
$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งาน', 'url' => ['user/admin']];
$this->params['breadcrumbs'][] = ['label' => $user['username'], 'url' => ['view', 'userid' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="roleuser-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'userid' => $model->user_id,
        'model' => $model,
    ])
    ?>

</div>
