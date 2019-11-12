<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\EquipoHasCategoria;

/**
 * EquipoHasCategoriaSearch represents the model behind the search form of `frontend\models\EquipoHasCategoria`.
 */
class EquipoHasCategoriaSearch extends EquipoHasCategoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipo_id', 'categoria_id', 'cantidad_actual', 'cantidad_maxima'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = EquipoHasCategoria::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'equipo_id' => $this->equipo_id,
            'categoria_id' => $this->categoria_id,
            'cantidad_actual' => $this->cantidad_actual,
            'cantidad_maxima' => $this->cantidad_maxima,
        ]);

        return $dataProvider;
    }
}
