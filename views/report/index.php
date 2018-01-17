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

    /* Customize the label (the container) */
    .containers {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .containers input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .containers:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .containers input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .containers input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .containers .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
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
$Web = new Web();
$profileModel = new Profile();
$profile = $profileModel->Getprofile();
$this->title = $model['reportname'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-index">
    <div style=" text-align: center; color: #007788; border: #e7e7e7 solid 1px; background: #FFFFFF;" class="alert">
        <h4><?php echo $model['note'] ?> ประจำสัปดาห์ที่ <?php echo $weeks['week'] ?></h4>
        หน่วยบริการ / โรงพยาบาล : <?php echo $profile['off_id'] . ' ' . $profile['off_name'] ?><br/>

        <?php echo "วันที่ " . $Web->thaidate($weeks['datestart']) . " ถึง " . $Web->thaidate($weeks['dateend']); ?>
        <input type="hidden" id="reportid" name="reportid" value="<?php echo $model['reportid'] ?>"/>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3">
            <?php if ($zero['zero'] == "0") { ?>
                <label class="containers">
                    <input type="checkbox" id="zero" <?php if ($zero['zero'] == "0") echo "checked"; ?> onclick="deleterecordzero()"/> ไม่มีผู้ป่วย
                    <span class="checkmark"></span>
                </label>
            <?php } else { ?>
                <label class="containers">
                    <input type="checkbox" onclick="recordzero()"/> ไม่มีผู้ป่วย
                    <span class="checkmark"></span>
                </label>
            <?php } ?>
        </div>
    </div>
    <?php if ($zero['zero'] == "0") { ?>
        <center>=== ไม่มีผู้ป่วย ===</center>
    <?php } else { ?>
        <div id="record">
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <label>รหัสบัตรประชาชน</label>
                    <input type="text" class="form-control" id="cidsearch" placeholder="รหัสบัตรประชาชน ..."/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label>ชื่อ</label>
                    <input type="text" class="form-control" id="namesearch" placeholder="ชื่อ ..."/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <label>นามสกุล</label>
                    <input type="text" class="form-control" id="lnamesearch" placeholder="นามสกุล ..."/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <button type="button" class="btn btn-success btn-block" style=" margin-top: 23px;" onclick="Searchperson()">
                        <i class="fa fa-search"></i>ค้นหา
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    
                    <div class="alert" style="border: #e7e7e7 solid 1px;background: #FFFFFF;">
                        <div id="result" style=" height: 350px; overflow: auto;">
                            <center><div style=" margin-top: 15%;"><i class="fa fa-users fa-5x"></i> &nbsp; <i class="fa fa-search fa-5x"></i></div></center>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="alert" style="border: #e7e7e7 solid 1px;background: #FFFFFF;">
                        <div class="row">
                            <div class="col-md-3 col-lg-3" style=" text-align: right;">*ชื่อ-สกุล : </div>
                            <div class="col-md-9 col-lg-9">
                                <input type="text" class="form-control" id="name" name="lname"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-lg-3" style=" text-align: right;">*บัตรประชาชน : </div>
                            <div class="col-md-9 col-lg-9">
                                <input type="text" class="form-control" id="cid" name="cid" maxlength="13" onKeyUp="if (this.value * 1 != this.value)
                                                this.value = '';"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-lg-3" style=" text-align: right;">*ที่อยู่ : </div>
                            <div class="col-md-9 col-lg-9">
                                <textarea id="address" name="address" rows="6" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-lg-3" style=" text-align: right;">ผู้รายงาน : </div>
                            <div class="col-md-9 col-lg-9">
                                <input type="text" id="user" class="form-control" value="<?php echo $user['name'] ?>" readonly="readonly"/>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-success" onclick="Savereport()"><i class="fa fa-save"></i> บันทึกข้อมูล</button> 
                                    <button type="button" class="btn btn-danger" onclick="Oncancel()"><i class="fa fa-remove"></i> ยกเลิก</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-user"></i> รายชื่อผู้ป่วยที่รายงาน</div>
                    <div id="report"></div>
                </div>

            </div>
        </div>

    <?php } ?>

</div>

<?php
$this->registerJs('
        Getreport();
       ');
?>
<script type="text/javascript">
    function Searchperson() {
        Oncancel();
        var url = "<?php echo Url::to(['report/searchperson']) ?>";
        var CID = $("#cidsearch").val();
        var NAME = $("#namesearch").val();
        var LNAME = $("#lnamesearch").val();
        var data = {CID: CID, NAME: NAME, LNAME: LNAME};
        if (CID == "" && NAME == "" && LNAME == "") {
            alert("เลือกอย่างน้อย 1 เงื่อนไข");
            return false;
        }
        $("#result").html("<center>กำลังค้นหารายชื่อ ...</center>");
        $.post(url, data, function (datas) {
            $("#result").html(datas);
        });
    }

    function Getperson(CID) {
        var url = "<?php echo Url::to(['report/getperson']) ?>";
        $("#CID").val(CID);

        var data = {CID: CID};
        $.post(url, data, function (datas) {
            $("#name").val(datas.name);
            $("#cid").val(datas.cid);
            $("#address").val(datas.address);
        }, 'json');
    }

    function Oncancel() {
        $("#name").val('');
        $("#cid").val('');
        $("#address").val('');
    }

    function Savereport() {
        var url = "<?php echo Url::to(['report/savereport']) ?>";
        var name = $("#name").val();
        var cid = $("#cid").val();
        var address = $("#address").val();
        var reportid = $("#reportid").val();
        var week = "<?php echo $weeks['week'] ?>";
        var year = "<?php echo $weeks['year'] ?>";
        var cidlength = cid.length;
        var hospcode = "<?php echo $profile['location'] ?>";
        if (name == "" || cid == "" || address == "") {
            alert("เครื่องหมาย * ต้องไม่ว่าง");
            return false;
        }

        if (cidlength != 13) {
            alert("เลขบัตรประชาชนไม่ถูกต้อง ...");
            return false;
        }

        var data = {cid: cid, name: name, address: address, reportid: reportid, week: week, hospcode: hospcode, year: year};
        $.post(url, data, function (datas) {
            if (datas == 1) {
                alert("บันทึกคนนี้ในช่วงเวลานี้แล้ว ....");
                return false;
            } else {
                Getreport();
            }
        });
    }

    function Getreport() {
        var url = "<?php echo Url::to(['report/getreport']) ?>";
        var reportid = $("#reportid").val();
        var week = "<?php echo $weeks['week'] ?>";
        var year = "<?php echo $weeks['year'] ?>";
        var hospcode = "<?php echo $profile['location'] ?>";
        var data = {reportid: reportid, week: week, year: year, hospcode: hospcode};
        $.post(url, data, function (datas) {
            $("#report").html(datas);
            Oncancel();
        });
    }

    function recordzero() {
        var r = confirm("ยืนยันการบันทึกข้อมูล ...");
        if (r == true) {
            var url = "<?php echo Url::to(['report/recordzeroreport']) ?>";
            var reportid = $("#reportid").val();
            var week = "<?php echo $weeks['week'] ?>";
            var year = "<?php echo $weeks['year'] ?>";
            var hospcode = "<?php echo $profile['location'] ?>";
            var data = {reportid: reportid, week: week, year: year,hospcode: hospcode};
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }

    function deleterecordzero() {
        var r = confirm("ยืนยันการบันทึกข้อมูล ...");
        if (r == true) {
            var url = "<?php echo Url::to(['report/deletezeroreport']) ?>";
            var reportid = $("#reportid").val();
            var week = "<?php echo $weeks['week'] ?>";
            var year = "<?php echo $weeks['year'] ?>";
            var hospcode = "<?php echo $profile['location'] ?>";
            var data = {reportid: reportid, week: week, year: year,hospcode: hospcode};
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }


</script>


