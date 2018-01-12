<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zerorecord".
 *
 * @property int $id
 * @property int $report_id
 * @property int $week
 * @property string $month
 * @property string $year
 * @property string $hospcode
 * @property int $userid
 * @property int $zero
 */
class Zerorecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zerorecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id', 'week', 'userid', 'zero'], 'integer'],
            [['month'], 'string', 'max' => 2],
            [['year'], 'string', 'max' => 4],
            [['hospcode'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_id' => 'Report ID',
            'week' => 'Week',
            'month' => 'Month',
            'year' => 'Year',
            'hospcode' => 'Hospcode',
            'userid' => 'Userid',
            'zero' => 'Zero',
        ];
    }
}
