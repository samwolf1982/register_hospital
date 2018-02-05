<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctor_status".
 *
 * @property int $id
 * @property string $name Cтатус врача
 *
 * @property Doctor[] $doctors
 */
class DoctorStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Cтатус врача',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['status_id' => 'id']);
    }
}
