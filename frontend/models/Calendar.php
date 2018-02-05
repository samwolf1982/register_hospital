<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property int $id
 * @property string $date Дата (год-мес-день)
 * @property int $doctor_id Врач
 * @property string $created_at Время создания
 *
 * @property Doctor $doctor
 * @property CalendarToDayPeriod[] $calendarToDayPeriods
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
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarToDayPeriods()
    {
        return $this->hasMany(CalendarToDayPeriod::className(), ['calendar_id' => 'id']);
    }
}
