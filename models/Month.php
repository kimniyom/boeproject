<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "month".
 *
 * @property string $id
 * @property string $month_th
 * @property string $mount_en
 * @property string $month_th_shot
 */
class Month extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'month';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['month_th', 'mount_en'], 'string', 'max' => 100],
            [['month_th_shot'], 'string', 'max' => 10],
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
            'month_th' => 'Month Th',
            'mount_en' => 'Mount En',
            'month_th_shot' => 'Month Th Shot',
        ];
    }
}
