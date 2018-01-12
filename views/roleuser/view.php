<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Groupprivilege;
use app\models\CoOffice;

/* @var $this yii\web\View */
/* @var $model app\models\Roleuser */

$this->title = $user['username'];
$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งาน', 'url' => ['user/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="roleuser-view">

    <?php if (empty($roleuser['group_id'])) { ?>
    <h4>*ยังไม่ได้กำหนดสิทธิ์</h4>
        <?= Html::a('เพิ่มสิทธิ์', ['create', 'userid' => $userid], ['class' => 'btn btn-success']) ?>
    <?php } else { ?>
        <h4>กลุ่ม : <?php echo Groupprivilege::findOne(['groupcode' => $roleuser['group_id']])['groupname'] ?></h4>
        <hr/>
        <?= Html::a('แก้ไข', ['update', 'id' => $roleuser['id']], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('ลบ', ['delete', 'id' => $roleuser['id']], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
        <br/><br/>
    <?php } ?>
    <div class="list-group">
        <?php foreach ($rolepcu as $rs): ?>
            <div class="list-group-item"><?php echo $rs['hospcode'] . " " . CoOffice::findOne(['off_id' => $rs['hospcode']])['off_name'] ?></div>
        <?php endforeach; ?>
    </div>
</div>
