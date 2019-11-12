<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "equipo".
 *
 * @property int $id
 * @property string $nombre
 * @property int $cantidad_integrantes
 * @property int $user_id
 *
 * @property User $user
 * @property EquipoHasCategoria[] $equipoHasCategorias
 * @property Integrante[] $integrantes
 */
class Equipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['user_id'], 'required'],
            [['nombre'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'cantidad_integrantes' => 'Cantidad Integrantes',
            'user_id' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipoHasCategorias()
    {
        return $this->hasMany(EquipoHasCategoria::className(), ['equipo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['equipo_id' => 'id']);
    }
}
