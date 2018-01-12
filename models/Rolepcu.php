<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rolepcu".
 *
 * @property int $id
 * @property int $groupid
 * @property string $hospcode
 * @property string $distid
 */
class Rolepcu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rolepcu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupid'], 'integer'],
            [['hospcode', 'distid'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupid' => 'Groupid',
            'hospcode' => 'Hospcode',
            'distid' => 'Distid',
        ];
    }
}
