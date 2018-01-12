<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masreport".
 *
 * @property int $reportid
 * @property string $reportname
 * @property string $note
 * @property int $active
 */
class Masreport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'masreport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reportname','active'],'required'],
            [['note'], 'string'],
            [['active'], 'integer'],
            [['reportname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reportid' => 'Reportid',
            'reportname' => 'Reportname',
            'note' => 'Note',
            'active' => 'Active',
        ];
    }
}
