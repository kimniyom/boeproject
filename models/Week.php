<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "week".
 *
 * @property int $id
 * @property string $month
 * @property string $year
 * @property string $datestart
 * @property string $dateend
 * @property int $week
 */
class Week extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'week';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year','month','week','datestart','dateend'],'required'],
            [['datestart', 'dateend'], 'safe'],
            [['week'], 'integer'],
            [['month'], 'string', 'max' => 2],
            [['year'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
            'year' => 'Year',
            'datestart' => 'Datestart',
            'dateend' => 'Dateend',
            'week' => 'Week',
        ];
    }
}
