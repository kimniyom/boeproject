<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roleuser".
 *
 * @property int $id
 * @property string $group_id
 * @property string $user_id
 */
class Roleuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roleuser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'user_id'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'user_id' => 'User ID',
        ];
    }
    
}
