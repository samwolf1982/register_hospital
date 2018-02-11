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
 * @property int $profession_id Выберите специализацию врача
 * @property int $period_id Период
 * @property int $statusorder_id Состояние заявки
 * @property string $date Дата
 * @property string $date_created Дата создания
 * @property string $hash хеш урла для предотврашениея повторных заявок
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
            [[ 'doctor_id', 'period_id', 'date', 'date_created'], 'required'],
            [['cod'], 'required','message'=>'Введите ваш номер страхового полиса'],
            [['client_name', 'client_surname', 'client_patronymic','doctor_name'], 'string'],
            [['born', 'date', 'date_created'], 'safe'],
            [['doctor_id', 'profession_id', 'period_id', 'statusorder_id'], 'integer'],
            [[ 'hash'], 'string', 'max' => 255],
            [['cod'], 'string',  'min' => 16,'max' => 16,'length' => [16],'message'=>'Длина должна быть 16 символов','tooShort'=>'Длина должна быть 16 символов','tooLong'=>'Длина должна быть 16 символов'],
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
            'profession_id' => 'Выберите специализацию врача',
            'period_id' => 'Период',
            'statusorder_id' => 'Состояние заявки',
            'doctor_name' => 'Имя врача',
            'date' => 'Дата',
            'date_created' => 'Дата создания',
            'hash' => 'хеш урла для предотврашениея повторных заявок',
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
