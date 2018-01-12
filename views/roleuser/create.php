<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Roleuser */

$this->title = 'เพิ่มสิทธิ์';
$this->params['breadcrumbs'][] = ['label' => $user['username'], 'url' => ['roleuser/view','userid' => $userid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roleuser-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <?=
    $this->render('_form', [
        'userid' => $userid,
        'model' => $model,
    ])
    ?>

</div>
