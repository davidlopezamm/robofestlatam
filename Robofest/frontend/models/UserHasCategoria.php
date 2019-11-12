<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "user_has_categoria".
 *
 * @property int $id
 * @property int $user_id
 * @property int $categoria_id
 * @property int $cantidad_actual
 * @property int $cantidad_maxima
 *
 * @property Categoria $categoria
 * @property User $user
 */
class UserHasCategoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_has_categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'categoria_id'], 'required'],
            [['user_id', 'categoria_id', 'cantidad_actual'], 'integer'],
            [['cantidad_maxima'], 'integer', 'message' => 'Debe de comprar una cantidad entera de equipos.'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],

            ['cantidad_maxima', 'compare', 'compareValue' => 1, 'operator' => '>=', 'message' => 'Necesita comprar al menos 1.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'categoria_id' => 'Categoria',
            'cantidad_actual' => 'Cantidad Actual',
            'cantidad_maxima' => 'Cantidad Maxima',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
