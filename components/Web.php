<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Web extends Component {

    function weekOfMonth($date) {
        $firstOfMonth = date("Y-m-01", strtotime($date));
        $WEEK = intval(date("W", strtotime($date))) - intval(date("W", strtotime($firstOfMonth)));

        return $WEEK+1;
    }

    function thaidate($dateformat = "") {
        if (!empty($dateformat)) {
            $year = substr($dateformat, 0, 4);
            $month = substr($dateformat, 5, 2);
            $day = substr($dateformat, 8, 2);
            $thai = Array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

            if (strlen($dateformat) <= 10) {
                return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543);
            } else {
                return $thaidate = (int) $day . " " . $thai[(int) $month] . " " . ($year + 543) . " " . substr($dateformat, 10);
            }
        }
    }

    public function Getroleuser() {
        $user_id = Yii::$app->user->identity->id;
        if (Yii::$app->user->identity->status == "A") {
            $where = "1=1";
        } else {
            $where = "u.user_id = '$user_id'";
        }
        $sql = "SELECT r.hospcode
                FROM roleuser u INNER JOIN rolepcu r ON u.group_id = r.groupid
                WHERE $where";
        $result = \Yii::$app->db->createCommand($sql)->queryAll();
        $Arr = array();
        foreach ($result as $rs):
            $Arr[] = "'" . $rs['hospcode'] . "'";
        endforeach;
        $role = implode(",", $Arr);
        return $role;
    }

    public function WeekOfYear($year,$week){
        //$date = date("Y-m-d");
        //$week = date("N", strtotime($date));//นับลำดับวันที่ในสัปดาห์สัปดาห์ เช่น วันที่ 1,2,3.....
        //$week1 = date("W", strtotime($date));//นับสัปดาห์ตามจริงของปี เช่นวันนี้เป็นสัปดาห์ที่ 16 ของปี 2014
        //$start = date("Y-m-d",strtotime("-".($week-1)." days"));
        //$end = date("Y-m-d",strtotime("+".(7-$week)." days"));
        $date = new DateTime();
        $date->setISODate($year,$week);
        $start = $date->format("Y-m-d");
        $date->setISODate($year,$week,7);
        $end = $date->format("Y-m-d");

        //echo "วันนี้คือวันที่ : ".$week." ของสัปดาห์"."<br/>";
        //echo "วันนี้อยู่ในสัปดาห์ที่ : ".$week1." ของปี"."<br/>";
        echo "ประกอบด้วยวันที่ : ".$start." - ".$end."<br/>";

    }

    public function SetWeek(){
        $yearNow = date("Y");
        $sql = "SELECT MAX(year) as year FROM week";
        $rs = Yii::$app->db->createCommand($sql)->queryOne();
        if($rs['year'] > $yearNow){
            $dateLastweek = $yearNow."-12-31";
            $sqlCountWeek = "SELECT WEEK('$dateLastweek') AS lastweek";
            $rss = Yii::$app->db->createCommand($sql)->queryOne();
            $lastweek = ($rss['lastweek'] + 1);
            for($i=1;$i<=$lastweek;$i++):

            endfor;
        }
    }

}
