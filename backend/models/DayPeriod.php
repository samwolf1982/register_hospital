<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "day_period".
 *
 * @property int $id
 * @property string $name
 * @property string $type Тип записи время/текс
 *
 * @property Order[] $orders
 */
class DayPeriod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'day_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'string'],
            [['type'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'type' => 'Тип записи время/текс',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['period_id' => 'id']);
    }
}
