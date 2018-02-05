<?php

namespace app\models;

use Yii;

//      !!   add RULES                 [['id'], 'required'],     [['id'], 'integer'],

/**
 * This is the model class for table "profession".
 *
 * @property int $id
 * @property string $name
 *
 * @property Doctor[] $doctors
 */
class Profession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profession';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['id'], 'required'],
            [['id'], 'integer','message' => 'Пожалуйста выберите направление']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Выберите специализацию',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['profession_id' => 'id']);
    }
}
