<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "equipo_has_categoria".
 *
 * @property int $id
 * @property int $equipo_id
 * @property int $categoria_id
 * @property int $cantidad_actual
 * @property int $cantidad_maxima
 *
 * @property Equipo $equipo
 * @property Categoria $categoria
 */
class EquipoHasCategoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipo_has_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id', 'categoria_id'], 'required'],
            [['equipo_id', 'categoria_id', 'cantidad_actual', 'cantidad_maxima'], 'integer'],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::className(), 'targetAttribute' => ['equipo_id' => 'id']],
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
            'equipo_id' => 'Equipo ID',
            'categoria_id' => 'Categoria ID',
            'cantidad_actual' => 'Cantidad Actual',
            'cantidad_maxima' => 'Cantidad Maxima',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::className(), ['id' => 'equipo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }
}
