<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "co_office".
 *
 * @property string $off_id
 * @property string $off_id_new
 * @property string $off_name
 * @property string $off_type
 * @property string $address
 * @property string $road
 * @property string $provid
 * @property string $distid
 * @property string $subdistid
 * @property string $villid
 * @property string $villno
 * @property string $postcode
 * @property string $cup_code
 * @property string $pcu_code
 * @property string $pointx
 * @property string $pointy
 * @property string $status
 * @property string $hasdata
 * @property string $hasdataf12
 * @property string $hasdatancd
 * @property string $hasdatarefer
 * @property string $refermember
 * @property string $createdate
 * @property string $updatedate
 */
class CoOffice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'co_office';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['off_id'], 'required'],
            [['createdate', 'updatedate'], 'safe'],
            [['off_id', 'postcode', 'cup_code', 'pcu_code'], 'string', 'max' => 5],
            [['off_id_new'], 'string', 'max' => 9],
            [['off_name', 'road'], 'string', 'max' => 100],
            [['off_type', 'provid', 'villno'], 'string', 'max' => 2],
            [['address'], 'string', 'max' => 255],
            [['distid'], 'string', 'max' => 4],
            [['subdistid'], 'string', 'max' => 6],
            [['villid'], 'string', 'max' => 8],
            [['pointx', 'pointy'], 'string', 'max' => 50],
            [['status', 'hasdata', 'hasdataf12', 'hasdatancd', 'hasdatarefer', 'refermember'], 'string', 'max' => 1],
            [['off_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'off_id' => 'Off ID',
            'off_id_new' => 'Off Id New',
            'off_name' => 'Off Name',
            'off_type' => 'Off Type',
            'address' => 'Address',
            'road' => 'Road',
            'provid' => 'Provid',
            'distid' => 'Distid',
            'subdistid' => 'Subdistid',
            'villid' => 'Villid',
            'villno' => 'Villno',
            'postcode' => 'Postcode',
            'cup_code' => 'Cup Code',
            'pcu_code' => 'Pcu Code',
            'pointx' => 'Pointx',
            'pointy' => 'Pointy',
            'status' => 'Status',
            'hasdata' => 'Hasdata',
            'hasdataf12' => 'Hasdataf12',
            'hasdatancd' => 'Hasdatancd',
            'hasdatarefer' => 'Hasdatarefer',
            'refermember' => 'Refermember',
            'createdate' => 'Createdate',
            'updatedate' => 'Updatedate',
        ];
    }
}
