<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property int $id
 * @property string $date Дата (год-мес-день)
 * @property int $doctor_id Врач
 * @property string $timetable График работы
 * @property string $created_at Время создания
 *
 * @property Doctor $doctor
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'doctor_id', 'created_at'], 'required'],
            [['date', 'created_at'], 'safe'],
            [['doctor_id'], 'integer'],
            [['timetable','timetable_work'], 'string'],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            ['doctor_id', 'unique', 'targetAttribute' => ['doctor_id', 'date'],'message' => 'Этот врач уже вписана в выбраную вами дату. Попробуйте изменить день или врача.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата (год-мес-день)',
            'doctor_id' => 'Врач',
            'timetable' => 'График работы',
            'timetable_work' => 'График работы. например ( 9:00-18:00 )',
            'created_at' => 'Время создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id']);
    }
}
