<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctor".
 *
 * @property int $id
 * @property string $name Имя
 * @property string $surname Фамилия
 * @property string $patronymic Отчество
 * @property string $phone Телефон
 * @property int $status_id Статус врача
 * @property int $area_id Отделение
 * @property int $profession_id Специализация
 * @property string $photo Фотография
 *
 * @property Calendar[] $calendars
 * @property Area $area
 * @property DoctorStatus $status
 * @property Profession $profession
 * @property Order[] $orders
 */
class Doctor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'patronymic', 'phone', 'status_id', 'area_id', 'profession_id'], 'required'],
            [['status_id', 'area_id', 'profession_id'], 'integer'],
            [['photo'], 'string'],
            [['name', 'surname', 'patronymic', 'phone'], 'string', 'max' => 255],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => DoctorStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['profession_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profession::className(), 'targetAttribute' => ['profession_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'status_id' => 'Статус врача',
            'area_id' => 'Отделение',
            'profession_id' => 'Специализация',
            'photo' => 'Фотография',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendars()
    {
        return $this->hasMany(Calendar::className(), ['doctor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(DoctorStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfession()
    {
        return $this->hasOne(Profession::className(), ['id' => 'profession_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['doctor_id' => 'id']);
    }
}
