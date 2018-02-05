<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar_to_day_period".
 *
 * @property int $id
 * @property int $calendar_id День (ид)
 * @property int $day_period_id ид периода
 * @property int $status статус, занят | не занят
 *
 * @property Calendar $calendar
 * @property DayPeriod $dayPeriod
 */
class CalendarToDayPeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_to_day_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'day_period_id'], 'required'],
            [['calendar_id', 'day_period_id', 'status'], 'integer'],
            [['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
            [['day_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => DayPeriod::className(), 'targetAttribute' => ['day_period_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calendar_id' => 'День (ид)',
            'day_period_id' => 'ид периода',
            'status' => 'статус, занят | не занят',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar()
    {
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDayPeriod()
    {
        return $this->hasOne(DayPeriod::className(), ['id' => 'day_period_id']);
    }
}
