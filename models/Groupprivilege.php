<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "groupprivilege".
 *
 * @property int $id
 * @property string $groupcode
 * @property string $groupname
 */
class Groupprivilege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groupprivilege';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupcode'], 'string', 'max' => 10],
            [['groupname'], 'string', 'max' => 255],
            [['groupcode'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupcode' => 'Groupcode',
            'groupname' => 'Groupname',
        ];
    }
}
