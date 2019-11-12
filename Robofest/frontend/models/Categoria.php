<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $nombre
 * @property int $edad_min
 * @property int $edad_max
 *
 * @property Competencia[] $competencias
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edad_min', 'edad_max'], 'integer'],
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
            'edad_min' => 'Edad Min',
            'edad_max' => 'Edad Max',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompetencias()
    {
        return $this->hasMany(Competencia::className(), ['categoria_id' => 'id']);
    }
}
