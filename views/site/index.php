<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
    .site-index a{
        text-decoration: none;
    }
</style>
<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use app\components\Web;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Month;
use dektrium\user\models\Profile;

$web = new Web();
$this->title = 'MENU';
$profileModel = new Profile();
$profile = $profileModel->Getprofile();
$month = Month::find()->all();
$WEEK = $web->weekOfMonth(date("Y-m-d"));
$yearNow = date("Y");
$monthNow = date("m");
if (strlen($monthNow) < 2) {
    $monthNows = "0" . $monthNow;
} else {
    $monthNows = $monthNow;
}
?>
<div class="site-index">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <h1><i class="fa fa-calendar"></i> วันที่ <?php echo $web->thaidate(date("Y-m-d")) ?>
            </h1>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-4 col-lg-4">
            <div id="chart"></div>
        </div>
        <div class="col-md-8 col-lg-8 well">
            <?php
            if (!Yii::$app->user->isGuest) {
                if (Yii::$app->user->identity->status == "A") {
                    ?>
                    <h3 style=" margin-top: 0px;"><i class="fa fa-cogs"></i> ตั้งค่า</h3>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-4">
                            <a href="<?php echo Url::to(['user/admin']) ?>">
                                <button class="btn btn-default btn-block">
                                    <i class="fa fa-users fa-2x text-primary"></i><hr/>
                                    <h4>ผู้ใช้งาน</h4>
                                </button></a>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-4">
                            <a href="<?php echo Url::to(['masreport/index']) ?>">
                                <button class="btn btn-default btn-block">
                                    <i class="fa fa-file-text fa-2x text-primary"></i><hr/>
                                    <h4>จัดการแบบรายงาน</h4>
                                </button></a>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-4">
                            <a href="<?php echo Url::to(['week/index']) ?>">
                                <button class="btn btn-default btn-block">
                                    <i class="fa fa-clock-o fa-2x text-primary"></i><hr/>
                                    <h4>ตั้งค่าสัปดาห์</h4>
                                </button></a>
                        </div>
                    </div>
                <?php } else { ?>
                    <h3 style=" margin-top: 0px;"><i class="fa fa-download"></i> บันทึกผู้ป่วย</h3>
                    <div class="row">
                        <?php foreach ($report as $rs): ?>
                            <div class="col-md-3 col-lg-2 col-sm-4" style=" margin-bottom: 10px;">
                                <!--<a href="<?php //echo Url::to(['report/index', 'reportid' => $rs['reportid']])       ?>">-->
                                <button class="btn btn-primary btn-block" onclick="popuprecode('<?php echo $rs['reportid'] ?>')">
                                    <i class="fa fa-save fa-2x"></i><hr/>
                                    <p><?php echo $rs['reportname'] ?></p>
                                </button>
                                <!--</a>-->
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>
            <?php } ?>
            <h3><i class="fa fa-table"></i> รายงาน</h3>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <?php
                    $i = 0;
                    foreach ($report as $rs): $i++;
                        ?>
                        <a href="<?php echo Url::to(['reports/index', 'reportid' => $rs['reportid']]) ?>">
                            <?php echo $i . "." . $rs['note'] ?></a>
                        <br/>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="popupconfigrecode" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เลือกช่วงเวลาในการคีย์ข้อมูล</h4>
            </div>
            <div class="modal-body">
                <input id="report_id" type="hidden"/>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <select id="year" class="form-control" onchange="getWeek()">
                            <?php for ($i = $yearNow; $i >= ($yearNow - 1); $i--): ?>
                                <option value="<?php echo $i ?>"><?php echo ($i + 543) ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <div id="showweek"></div>
                       
                    </div>

                </div>

                <div id="day" style=" text-align: center;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" onclick="recode()">ตกลง</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
$this->registerJs("
        getWeek();
        Highcharts.chart('chart', {

    title: {
        text: 'ร้อยละผู้ป่วย'
    },
    credits: false,
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    xAxis: {
        categories: [" . $catchart . "]
    },

    series: [{
        type: 'pie',
        name: 'ร้อยละ',
        allowPointSelect: true,
        //keys: ['name', 'y', 'selected', 'sliced'],
        data: [" . $valchart . "],
        showInLegend: true
    }]
});
       ");
?>
<script type="text/javascript">
    function popuprecode(report_id) {
        $("#report_id").val(report_id);
        $("#popupconfigrecode").modal();
    }

    function getWeek(){
        var url = "<?php echo Url::to(['report/getweekofyear']) ?>";
        var year = $("#year").val();
        var data = {year: year};
        $.post(url, data, function (datas) {
            $("#showweek").html(datas);
        });
    }

    function getDayofWeek() {
        var url = "<?php echo Url::to(['report/getdayofweek']) ?>";
        var year = $("#year").val();
        //var month = $("#month").val();
        var week = $("#week").val();
        var data = {year: year,week: week};
        $.post(url, data, function (datas) {
            if (datas == "0") {
                $("#btn-save").hide();
                $("#day").html("ยังไม่ได้กำหนดช่วงเวลา ...!!!");
            } else {
                $("#day").html(datas);
                $("#btn-save").show();
            }
        });
    }

    function recode() {
        var year = $("#year").val();
        //var month = $("#month").val();
        var week = $("#week").val();
        var report_id = $("#report_id").val();
        window.location = "<?php echo Url::to(['report/index']) ?>" + "&reportid=" + report_id + "&year=" + year + "&week=" + week;
    }
</script>
