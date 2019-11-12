<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "integrante_has_competencia_has_categoria".
 *
 * @property int $id
 * @property int $integrante_id
 * @property int $competencia_has_categoria_id
 * @property number $rid
 *
 * @property CompetenciaHasCategoria $competenciaHasCategoria
 * @property Integrante $integrante
 */
class IntegranteHasCompetenciaHasCategoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integrante_has_competencia_has_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['integrante_id', 'competencia_has_categoria_id'], 'required'],
            [['integrante_id', 'competencia_has_categoria_id'], 'integer'],
            ['rid', 'number'],
            [['competencia_has_categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompetenciaHasCategoria::className(), 'targetAttribute' => ['competencia_has_categoria_id' => 'id']],
            [['integrante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Integrante::className(), 'targetAttribute' => ['integrante_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'integrante_id' => 'Integrante',
            'competencia_has_categoria_id' => 'Competencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetenciaHasCategoria()
    {
        return $this->hasOne(CompetenciaHasCategoria::className(), ['id' => 'competencia_has_categoria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrante()
    {
        return $this->hasOne(Integrante::className(), ['id' => 'integrante_id']);
    }
}
