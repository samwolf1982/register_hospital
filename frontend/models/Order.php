<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $cod Номер страхового полиса
 * @property string $client_name Имя
 * @property string $client_surname Фамилия
 * @property string $client_patronymic Отчество
 * @property string $born Год рождения
 * @property int $doctor_id Доктор
 * @property int $profession_id Специализация ид
 * @property int $period_id Период
 * @property int $statusorder_id Состояние заявки
 * @property string $date Дата
 * @property string $date_created Дата создания
 *
 * @property Doctor $doctor
 * @property DayPeriod $period
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod', 'doctor_id', 'period_id', 'date', 'date_created'], 'required'],
            [['client_name', 'client_surname', 'client_patronymic'], 'string'],
            [['born', 'date', 'date_created'], 'safe'],
            [['doctor_id', 'profession_id', 'period_id', 'statusorder_id'], 'integer'],
            [['cod'], 'string', 'max' => 255],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Doctor::className(), 'targetAttribute' => ['doctor_id' => 'id']],
            [['period_id'], 'exist', 'skipOnError' => true, 'targetClass' => DayPeriod::className(), 'targetAttribute' => ['period_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cod' => 'Номер страхового полиса',
            'client_name' => 'Имя',
            'client_surname' => 'Фамилия',
            'client_patronymic' => 'Отчество',
            'born' => 'Год рождения',
            'doctor_id' => 'Доктор',
            'profession_id' => 'Специализация ид',
            'period_id' => 'Период',
            'statusorder_id' => 'Состояние заявки',
            'date' => 'Дата',
            'date_created' => 'Дата создания',
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
    public function getPeriod()
    {
        return $this->hasOne(DayPeriod::className(), ['id' => 'period_id']);
    }
}
