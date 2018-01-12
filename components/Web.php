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

}
