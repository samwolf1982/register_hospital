<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'doctor_id', 'profession_id', 'period_id', 'statusorder_id'], 'integer'],
            [['cod', 'client_name', 'client_surname', 'client_patronymic', 'born', 'doctor_name', 'time_value', 'date', 'date_created', 'hash'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'born' => $this->born,
            'doctor_id' => $this->doctor_id,
            'profession_id' => $this->profession_id,
            'period_id' => $this->period_id,
            'statusorder_id' => $this->statusorder_id,
            'date' => $this->date,
            'date_created' => $this->date_created,
        ]);

        $query->andFilterWhere(['like', 'cod', $this->cod])
            ->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'client_surname', $this->client_surname])
            ->andFilterWhere(['like', 'client_patronymic', $this->client_patronymic])
            ->andFilterWhere(['like', 'doctor_name', $this->doctor_name])
            ->andFilterWhere(['like', 'time_value', $this->time_value])
            ->andFilterWhere(['like', 'hash', $this->hash]);

        return $dataProvider;
    }
}
