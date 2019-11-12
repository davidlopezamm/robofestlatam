<?php

namespace frontend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "integrante".
 *
 * @property int $id
 * @property string $nombre
 * @property string $correo
 * @property int $edad
 * @property string $genero
 * @property int $equipo_id
 *
 * @property Equipo $equipo
 */
class Integrante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integrante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id'], 'integer'],
            [['equipo_id', 'genero', 'edad', 'nombre'], 'required'],
            [['nombre', 'genero'], 'string', 'max' => 45],

//            ['edad', 'date'],
    //        ['correo', 'email'],
  //          ['correo', 'trim'],
            ['correo', 'required', 'message' => 'El correo es requerido'],
//            ['correo', 'email', 'message' => 'No es un correo valido.'],
            ['correo', 'unique', 'targetClass' => '\frontend\models\Integrante', 'message' => 'Este correo ya ha sido registrado por otro integrante.'],
            ['correo', 'string', 'max' => 100],
//            ['correo', 'validateCorreo'],

            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::className(), 'targetAttribute' => ['equipo_id' => 'id']],
        ];
    }
    public function validateCorreo($attribute, $params){
        $integrante = Integrante::find()->andFilterWhere(['=', 'correo', $this->correo])->all();
        $user = User::find()->andFilterWhere(['=', 'email', $this->correo])->all();
        if ($integrante || $user) {
            $this->addError($attribute, 'Debes de tener al menos 18 años para registrarte.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'correo' => 'Correo',
            'edad' => 'Fecha de nacimiento',
            'genero' => 'Género',
            'equipo_id' => 'Equipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::className(), ['id' => 'equipo_id']);
    }
}
