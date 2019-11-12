<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\IntegranteHasCompetenciaHasCategoria;

/**
 * IntegranteHasCompetenciaHasCategoriaSearch represents the model behind the search form of `frontend\models\IntegranteHasCompetenciaHasCategoria`.
 */
class IntegranteHasCompetenciaHasCategoriaSearch extends IntegranteHasCompetenciaHasCategoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'integrante_id', 'competencia_has_categoria_id'], 'integer'],
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
        $query = IntegranteHasCompetenciaHasCategoria::find();
        $query->innerJoin('integrante');
        //$query->innerJoin('integrante2');

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
            'integrante_id' => $this->integrante_id,
            'competencia_has_categoria_id' => $this->competencia_has_categoria_id,
//            'integrante.equipo_id = '.$id
        ]);

        return $dataProvider;
    }
}
