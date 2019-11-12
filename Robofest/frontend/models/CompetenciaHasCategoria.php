<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "competencia_has_categoria".
 *
 * @property int $id
 * @property int $Competencia_id
 * @property int $categoria_id
 *
 * @property Competencia $competencia
 * @property Categoria $categoria
 * @property EquipoHasCompetenciaHasCategoria[] $equipoHasCompetenciaHasCategorias
 */
class CompetenciaHasCategoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competencia_has_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Competencia_id', 'categoria_id'], 'required'],
            [['Competencia_id', 'categoria_id'], 'integer'],
            [['Competencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competencia::className(), 'targetAttribute' => ['Competencia_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Competencia_id' => 'Competencia',
            'categoria_id' => 'Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetencia()
    {
        return $this->hasOne(Competencia::className(), ['id' => 'Competencia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoHasCompetenciaHasCategorias()
    {
        return $this->hasMany(EquipoHasCompetenciaHasCategoria::className(), ['Competencia_has_categoria_id' => 'id']);
    }


    public function getfullName()
    {
        $genial = 'Competencia: '.$this->competencia->nombre.', categoría: '.$this->categoria->nombre;
        return $genial;
    }
}
