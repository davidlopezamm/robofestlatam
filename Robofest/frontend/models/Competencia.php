<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "competencia".
 *
 * @property int $id
 * @property string $nombre
 * @property int $num_integrantes
 *
 * @property CompetenciaHasCategoria[] $competenciaHasCategorias
 */
class Competencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['num_integrantes'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'num_integrantes' => 'Num Integrantes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetenciaHasCategorias()
    {
        return $this->hasMany(CompetenciaHasCategoria::className(), ['Competencia_id' => 'id']);
    }
}
