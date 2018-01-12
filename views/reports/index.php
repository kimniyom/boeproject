<style type="text/css">
    .row{
        margin-bottom: 10px;
    }

    table thead tr th{
        background: #006699;
        color: #e7e7e7;
    }

    table tbody tr td{
        font-size: 12px;
    }


</style>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Web;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dektrium\user\models\Profile;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$web = new Web();
$this->title = $model['reportname'];
$this->params['breadcrumbs'][] = $this->title;
$WEEK = $web->weekOfMonth(date("Y-m-d"));
?>

<h4 style=" color: #008CBA;"><?php echo $model['note'] ?></h4>
<hr style=" margin-bottom: 0px;"/>
<div class="row" style=" border-bottom: #e6e6e6 solid 1px;">
    <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12" id="b-menu" style="color: #008CBA;">

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <label>ปี พ.ศ.</label>
                <select id="year" class="form-control">
                    <?php
                    $yearnow = date("Y");
                    for ($i = $yearnow; $i >= $yearnow - 1; $i--):
                        ?>
                        <option value="<?php echo $i ?>"><?php echo ($i + 543) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <label>เดือน</label>
                <select id="month" class="form-control">
                    <option value="">ทั้งหมด</option>
                    <?php
                    $monthnow = date("m");
                    if (strlen($monthnow) < 2) {
                        $monthnows = "0" . $monthnow;
                    } else {
                        $monthnows = $monthnow;
                    }
                    foreach ($month as $m):
                        ?>
                        <option value="<?php echo $m['id'] ?>" <?php if ($m['id'] == $monthnows) echo "selected"; ?>><?php echo $m['month_th'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <label>สถานบริการ</label>
                <select id="hospcode" class=" form-control">
                    <option value="">ทั้งหมด</option>
                    <?php foreach ($pcu as $pcus): ?>
                        <option value="<?php echo $pcus['groupcode'] ?>"><?php echo $pcus['groupcode'] . ' ' . $pcus['groupname'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <label>สัปดาห์</label>
                <select id="week" class=" form-control">
                    <option value="">ทั้งหมด</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <button type="button" class="btn btn-success btn-block" style=" margin-top: 25px;" onclick="Getreport()">ตกลง</button>
            </div>
        </div>

    </div>

    <div class="col-md-9 col-lg-9" id="b-content">
        <div id="report"></div>
    </div>
</div>
<?php
$this->registerJs("
            Getreport();
           $(document).ready(function(){
                var w = window.innerWidth;
                if(w >= 786){
                    $('#b-content').css({'min-height':'400px','border-left':'#e6e6e6 solid 1px'});
                }
           });
            ");
?>
<script type="text/javascript">
    function Getreport() {
        $("#report").html("กำลังโหลดข้อมูล ...");
        var url = "<?php echo Url::to(['reports/getreport']) ?>";
        var reportid = "<?php echo $reportid ?>";
        var week = $("#week").val();
        var year = $("#year").val();
        var month = $("#month").val();
        var hospcode = $("#hospcode").val();
        var data = {reportid: reportid, week: week, year: year, month: month, hospcode: hospcode};
        $.post(url, data, function (datas) {
            $("#report").html(datas);
        });
    }
</script>

