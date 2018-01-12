<?php

namespace app\controllers;

use Yii;
use app\models\Report;
use app\models\ReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Masreport;
use app\components\Web;
use yii\helpers\Json;
use dektrium\user\models\Profile;
use app\models\Roleuser;
use app\models\Month;
use app\models\Groupprivilege;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Report models.
     * @return mixed
     */
    public function actionIndex($reportid) {
        $Web = new Web();
        if (Yii::$app->user->identity->status == "A") {
            $data['pcu'] = Groupprivilege::findAll(['type' => '1']);
        } else {
            $hospcode = str_replace("'", '', $Web->Getroleuser());
            $data['pcu'] = Groupprivilege::findAll(['groupcode' => $hospcode]);
        }

        $data['reportid'] = $reportid;
        $data['month'] = Month::find()->all();
        $data['model'] = Masreport::findOne(['reportid' => $reportid]);
        return $this->render('index', $data);
    }

    public function actionGetreport() {

        $reportid = \Yii::$app->request->post('reportid');
        $year = \Yii::$app->request->post('year');
        $month = \Yii::$app->request->post('month');
        $week = \Yii::$app->request->post('week');
        $hospcode = \Yii::$app->request->post('hospcode');

        if (!empty($hospcode)) {
            $report = $this->Getrecode($reportid, $year, $month, $week, $hospcode);
        } else {
            $report = $this->Getpcu($reportid, $year, $month, $week);
        }

        echo $report;
    }

    private function Getpcu($reportid, $year, $month, $week) {
        $where = "";
        if ($month != "") {
            $where .= " AND month = '$month' ";
        } else {
            $where .= "";
        }

        if ($week != "") {
            $where .= " AND week = '$week' ";
        } else {
            $where .= "";
        }

        $sql = "SELECT Q.groupcode,Q.groupname,IFNULL(SUM(Q.total),'-') AS total
                    FROM(
                        SELECT g.groupcode,g.groupname,Q1.total
                        FROM groupprivilege g LEFT JOIN (
                            SELECT hospcode,COUNT(*) AS total
                            FROM report
                            WHERE reportid = '$reportid' AND `year` = '$year' $where
                            GROUP BY hospcode
                        ) Q1 ON g.groupcode = Q1.hospcode
                        WHERE g.type = '1'

                        UNION ALL

                        SELECT g.groupcode,g.groupname,Q1.total
                            FROM groupprivilege g LEFT JOIN (
                            SELECT hospcode,zero AS total FROM zerorecord WHERE report_id = '$reportid' AND `year` = '$year' $where
                        ) Q1 ON g.groupcode = Q1.hospcode

                    WHERE g.type = '1'
                    ) Q
                    GROUP BY Q.groupcode";
        $result = \Yii::$app->db->createCommand($sql)->queryAll();

        //$url = \yii\helpers\Url::to(['reports/export', 'reportid' => $reportid, 'year' => $year, "month" => $month, "week" => $week]);
         $str = "<script type='text/javascript'>$('#t-report').dataTable({";
        $str .= "'searching': false";
        //$str .= "'searching': false";
        $str .= "});</script>";
        //$str .= '<a href="' . $url . '" target="_bank" class="pull-right"><button type="button" class="btn btn-default"><i class="fa fa-file"></i> ส่งออก excel</button></a>';
        $str .= "<table class='cell-border' id='t-report'><thead><tr>";
        $str .= "<th style='text-align:center;'>#</th>";
        $str .= "<th>สถานบริการ</th>";
        $str .= "<th style='text-align:center; width:20%;'>จำนวนผู้ป่วย</th>";
        $str .= "</tr></thead><tbody>";
        $i = 0;
        foreach ($result as $rs):$i++;
        if($rs['total'] == "-"){
            $bg = 'color:red';
            $text = 'ไม่บันทึกข้อมูล';
        } else {
            $bg = 'color:none';
            $text = $rs['total'];
        }
            $str .= "<tr style='".$bg."'>";
            $str .= "<td style='text-align:center;'>" . $i . "</td>";
            $str .= "<td>" . $rs['groupcode'] . " " . $rs['groupname'] . "</td>";
            $str .= "<td style='text-align:center;'><b>" . $text . "</b></td>";
            $str .= "</tr>";
        endforeach;
        $str .= "</tbody></table>";
        return $str;
    }

    private function Getrecode($reportid, $year, $month, $week) {
        $where = "";
        if ($month != "") {
            $where .= " AND month = '$month' ";
        } else {
            $where .= "";
        }

        if ($week != "") {
            $where .= " AND week = '$week' ";
        } else {
            $where .= "";
        }


        $sql = "SELECT r.*,p.name AS author
                FROM report r INNER JOIN profile p ON r.userid = p.user_id
                WHERE r.reportid = '$reportid' AND LEFT(r.createdate,4) = '$year' $where ";
        $result = \Yii::$app->db->createCommand($sql)->queryAll();

        $url = \yii\helpers\Url::to(['reports/export', 'reportid' => $reportid, 'year' => $year, "month" => $month, "week" => $week]);

        $str = "<script type='text/javascript'>$('#t-report').dataTable({";
        $str .= "'searching': false";
        //$str .= "'searching': false";
        $str .= "});</script>";
        //$str .= '<a href="' . $url . '" target="_bank" class="pull-right"><button type="button" class="btn btn-default"><i class="fa fa-file"></i> ส่งออก excel</button></a>';
        $str .= "<table class='cell-border' id='t-report'><thead><tr>";
        $str .= "<th>#</th>";
        $str .= "<th>ชื่อ - สกุล</th>";
        $str .= "<th>ที่อยู่</th>";
        $str .= "<th>ผู้บันทึก</th>";
        $str .= "<th>วันที่</th>";
        $str .= "</tr></thead><tbody>";
        $i = 0;
        foreach ($result as $rs):$i++;
            $str .= "<tr>";
            $str .= "<td>" . $i . "</td>";
            $str .= "<td>" . $rs['name'] . "</td>";
            $str .= "<td>" . $rs['address'] . "</td>";
            $str .= "<td>" . $rs['author'] . "</td>";
            $str .= "<td>" . $rs['createdate'] . "</td>";
            $str .= "</tr>";
        endforeach;
        $str .= "</tbody></table>";

        return $str;
    }

    public function actionExport($reportid = null, $year = null, $month = null, $week = null) {
        $where = "";
        $title = $year;
        if ($month != "") {
            $where .= " AND SUBSTR(r.createdate,6,2) = '$month' ";
            $title .= "_" . $month;
        } else {
            $where .= "";
        }

        if ($week != "") {
            $where .= " AND WEEK = '$week' ";
            $title .= "week_" . $week;
        } else {
            $where .= "";
        }

        $data['model'] = Masreport::findOne(['reportid' => $reportid]);
        $data['title'] = $title;
        $sql = "SELECT r.*,p.name AS author
                FROM report r INNER JOIN profile p ON r.userid = p.user_id
                WHERE r.reportid = '$reportid' AND LEFT(r.createdate,4) = '$year' $where ";
        $data['result'] = \Yii::$app->db->createCommand($sql)->queryAll();
        //print_r($data['result']);
        return $this->renderPartial('export', $data);
    }

}
