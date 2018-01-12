<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int $reportid
 * @property int $week
 * @property string $cid
 * @property string $name
 * @property int $userid
 * @property string $createdate
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'reportid', 'week', 'userid'], 'integer'],
            [['createdate'], 'safe'],
            [['cid'], 'string', 'max' => 13],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reportid' => 'Reportid',
            'week' => 'Week',
            'cid' => 'Cid',
            'name' => 'Name',
            'userid' => 'Userid',
            'createdate' => 'Createdate',
        ];
    }
}
