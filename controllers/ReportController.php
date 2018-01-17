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
use app\models\Week;
use app\models\Month;
use app\models\Zerorecord;

/**
 * ReportController implements the CRUD actions for Report model.
 */
class ReportController extends Controller {

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
    public function actionIndex($reportid, $year, $week) {
        //$web = new Web();
        //$role = $web->Getroleuser();
        $data['user'] = Profile::findOne(['user_id' => Yii::$app->user->identity->id]);
        //$sql = "SELECT CID,CONCAT(CID,' ',NAME,' ',LNAME) AS PNAME FROM takisdb.person WHERE HOSPCODE IN($role) AND DISCHARGE = '9' limit 1000";
        //$data['person'] = \Yii::$app->db->createCommand($sql)->queryAll();

        $data['weeks'] = Week::findOne(['year' => $year,'week' => $week]);
        $data['zero'] = Zerorecord::findOne(['report_id' => $reportid, 'year' => $year,'week' => $week, 'hospcode' => $data['user']['location']]);
        $data['model'] = Masreport::findOne(['reportid' => $reportid]);
        return $this->render('index', $data);
    }

    /**
     * Displays a single Report model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Report model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Report();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Report model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Report model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete() {
        $id = Yii::$app->request->post('id');
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Report model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Report the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Report::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetperson() {
        $cids = \Yii::$app->request->post('CID');
        $strln = strlen($cids);
        if ($strln < 13) {
            //$number = (13 - $strln);
            $cid = sprintf("%013d", $cids);
        } else {
            $cid = $cids;
        }

        $sql = "SELECT CID,NAME,LNAME,SHORT_NAME FROM takisdb.person p INNER JOIN mas_prename m ON p.PRENAME = m.OID WHERE CID = '$cid'";

        $rs = \Yii::$app->db->createCommand($sql)->queryOne();

        if ($rs['CID']) {
            $sqladdress = "SELECT HOUSENO,ROAD,VILLANAME,tambonname,ampurname,changwatname
                    FROM takisdb.address a INNER JOIN takisdb.cchangwat c ON a.CHANGWAT = c.changwatcode
                    INNER JOIN takisdb.campur am ON a.CHANGWAT = am.changwatcode AND a.AMPUR = am.ampurcode
                    INNER JOIN takisdb.ctambon t ON a.CHANGWAT = t.changwatcode AND a.AMPUR = t.ampurcode AND a.TAMBON = t.tamboncode
                    WHERE CID = '" . $rs['CID'] . "'";
            $rsAdd = \Yii::$app->db->createCommand($sqladdress)->queryOne();
            $address = "";
            if ($rsAdd['HOUSENO']) {
                $address .= $rsAdd['HOUSENO'];
            } else {
                $address .= "";
            }
            if ($rsAdd['VILLANAME']) {
                $address .= ' หมู่บ้าน' . $rsAdd['VILLANAME'];
            } else {
                $address .= "";
            }
            if ($rsAdd['tambonname']) {
                $address .= ' ตำบล' . $rsAdd['tambonname'];
            } else {
                $address .= "";
            }
            if ($rsAdd['ampurname']) {
                $address .= ' อำเภอ' . $rsAdd['ampurname'];
            } else {
                $address .= "";
            }
            if ($rsAdd['changwatname']) {
                $address .= ' จังหวัด' . $rsAdd['changwatname'];
            } else {
                $address .= "";
            }
        } else {
            $address = "";
        }
        $json = array(
            'name' => $rs['SHORT_NAME'] . $rs['NAME'] . ' ' . $rs['LNAME'],
            'cid' => $rs['CID'],
            "address" => $address
        );

        echo json_encode($json);
    }

    public function actionSavereport() {
        $cid = \Yii::$app->request->post('cid');
        $name = \Yii::$app->request->post('name');
        $address = \Yii::$app->request->post('address');
        $reportid = \Yii::$app->request->post('reportid');
        $week = \Yii::$app->request->post('week');
        $year = \Yii::$app->request->post('year');
        $hospcode = \Yii::$app->request->post('hospcode');
        $userid = Yii::$app->user->identity->id;

        $sql = "SELECT * FROM report WHERE reportid = '$reportid' AND cid = '$cid' AND week = '$week' AND year = '$year'";
        $rs = \Yii::$app->db->createCommand($sql)->queryOne();
        if (!empty($rs['cid'])) {
            echo "1";
        } else {
            $columns = array(
                "reportid" => $reportid,
                "cid" => $cid,
                "name" => $name,
                "address" => $address,
                "week" => $week,
                "userid" => $userid,
                "hospcode" => $hospcode,
                "year" => $year,
                "createdate" => date("Y-m-d H:i:s")
            );
            \Yii::$app->db->createCommand()
                    ->insert("report", $columns)
                    ->execute();
            echo "0";
        }
    }

    public function actionGetreport() {
        $web = new Web();
        $role = $web->Getroleuser();
        $week = \Yii::$app->request->post('week');
        $reportid = \Yii::$app->request->post('reportid');
        $year = \Yii::$app->request->post('year');
        $sql = "SELECT r.*,p.name AS author
                FROM report r INNER JOIN profile p ON r.userid = p.user_id
                WHERE r.reportid = '$reportid' AND r.week = '$week' AND r.year = '$year' AND r.hospcode IN($role)";

        $data['report'] = \Yii::$app->db->createCommand($sql)->queryAll();

        return $this->renderPartial('report', $data);
    }

    public function actionSearchperson() {
        $cid = \Yii::$app->request->post('CID');
        $name = \Yii::$app->request->post('NAME');
        $lname = \Yii::$app->request->post('LNAME');

        if ($cid != "") {
            $where = "CID = '$cid' ";
        } else if ($name != "" && $cid != "" && $lname != "") {
            $where = "CID = '$cid' AND NAME = '$name' AND LNAME = '$lname'";
        } else if ($cid == "" && $name != "" && $lname == "") {
            $where = "NAME LIKE '%$name%'";
        } else if ($cid == "" && $name == "" && $lname != "") {
            $where = "LNAME LIKE '%$lname%'";
        } else if ($cid == "" && $name != "" && $lname != "") {
            $where = "NAME = '$name' AND LNAME = '$lname'";
        }


        $sql = "SELECT HOSPCODE,CID,NAME,LNAME,SHORT_NAME 
                FROM takisdb.person p INNER JOIN mas_prename m ON p.PRENAME = m.OID 
                WHERE $where AND CID_FLAG = '1'
                GROUP BY CID";
        $result = \Yii::$app->db->createCommand($sql)->queryAll();

        $str = "<div class='list-group'>";
        $i = 0;
        foreach ($result as $rs):$i++;
            $CID = $rs['CID'];
            $str .= "<a href='javascript:Getperson(" . $CID . ")' class='list-group-item' style='font-size:12px; color:#007788;'>";
            $str .= $i . $rs['CID'] . " " . $rs['SHORT_NAME'] . $rs['NAME'] . " " . $rs['LNAME'];
            $str .= '<span class="badge" style="background:green;">เลือก <i class="fa fa-chevron-right"></i></span>';
            $str .= "</a>";
        endforeach;
        $str .= "</div>";

        echo $str;
    }

    public function actionGetdayofweek() {
        $Web = new Web();
        $year = \Yii::$app->request->post('year');
        $week = \Yii::$app->request->post('week');

        $rs = Week::findOne(['year' => $year,'week' => $week]);
        if ($rs) {
            $day = "วันที่ " . $Web->thaidate($rs['datestart']) . " ถึง " . $Web->thaidate($rs['dateend']);
        } else {
            $day = 0;
        }

        echo $day;
    }

    public function actionRecordzeroreport() {
        $year = \Yii::$app->request->post('year');
        $week = \Yii::$app->request->post('week');
        $reportid = \Yii::$app->request->post('reportid');
        $hospcode = \Yii::$app->request->post('hospcode');

        Yii::$app->db->createCommand()
                ->delete("report", "reportid = '$reportid' AND hospcode = '$hospcode' AND week = '$week'")
                ->execute();

        $columns = array(
            "report_id" => $reportid,
            "year" => $year,
            "week" => $week,
            "hospcode" => $hospcode,
            "userid" => Yii::$app->user->identity->id,
            "zero" => "0"
        );

        Yii::$app->db->createCommand()
                ->insert("zerorecord", $columns)
                ->execute();
    }

    public function actionDeletezeroreport() {
        $year = \Yii::$app->request->post('year');
        $week = \Yii::$app->request->post('week');
        $reportid = \Yii::$app->request->post('reportid');
        $hospcode = \Yii::$app->request->post('hospcode');
        
        Yii::$app->db->createCommand()
                ->delete("report", "reportid = '$reportid' AND hospcode = '$hospcode' AND week = '$week' AND year = '$year' ")
                ->execute();
        
        Yii::$app->db->createCommand()
                ->delete("zerorecord", "report_id = '$reportid' AND hospcode = '$hospcode' AND week = '$week' AND year = '$year'")
                ->execute();
    }

    public function actionGetweekofyear(){
        $year = \Yii::$app->request->post('year');
        $weekNow = date("W", strtotime(date('Y-m-d')));
        $week = \Yii::$app->request->post('week');
        $weekNows = $weekNow;
        $yearNow = date("Y");
        if($year < $yearNow){
            $sql = "SELECT * FROM week WHERE year = '$year'";
            $weekdata = Yii::$app->db->createCommand($sql)->queryAll();
        } else if($year == $yearNow){
            $sql = "SELECT * FROM week WHERE year = '$year' AND week <= '$weekNows' ";
            $weekdata = Yii::$app->db->createCommand($sql)->queryAll();
        }

        $str = "";
        $str .= "<select id='week' class='form-control' onchange='getWeek()'>";
        foreach($weekdata as $rs):
            if($week == ""){
                if($weekNows == $rs['week'] && $yearNow == $year){
                    $select = "selected";
                } else {
                    $select = "";
                }
            } else {
                if($week == $rs['week']){
                    $select = "selected";
                } else {
                    $select = "";
                }
                
            }
            $str .= "<option value='".$rs['week']."' $select>สัปดาห์ที่ ".$rs['week']."</option>";
        endforeach;
        $str .= "</select>";
        echo $str;
    }

}
