<?php
namespace frontend\models;

use backend\models\AuthAssignment;
use yii\base\Model;
use common\models\User;
use yii2mod\rbac\RbacAsset;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $age;
    public $genre;
    public $institucion_proc;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'El nombre de usuario es requerido'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este usuario ya ha sido registrado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'El correo es requerido'],
            ['email', 'email', 'message' => 'No es un correo valido.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este correo ya ha sido registrado.'],

            ['password', 'required', 'message' => 'La contraseña es requerida'],
            ['password', 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute' => 'password_repeat', 'message' => 'Las contraseñas no coinciden.'],
            ['password_repeat', 'required', 'message' => 'Debe de volver a escribir su contraseña.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden.'],

            ['age', 'required', 'message' => 'La edad es requerida'],
            ['age', 'validateDates'],

            ['institucion_proc', 'string', 'max' => 150],
            [['genre', 'institucion_proc'], 'required'],

        ];
    }
    public function validateDates($attribute, $params){
        $edad = strtotime(date('d-m-Y', strtotime($this->age)));
        $event = strtotime('01-03-2002');
        if ($edad >= $event) {
            $this->addError($attribute, 'Debes de tener al menos 18 años para registrarte.');
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $this->age = date('Y-m-d', strtotime($this->age));
        $permission = new AuthAssignment();
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->genre = $this->genre;
        $user->age = $this->age;
        $user->institucion_proc = $this->institucion_proc;



        \Yii::$app->mailer->compose(['html' => 'signup'], ['user'=>$user])
        ->setTo($this->email)
        ->setFrom('l.tuxm950708@itses.edu.mxs')
        ->setSubject('¡Te acabas de registrar en el Robofest 2019!')
        ->send();



        $user->save();
        $permission->user_id = $user->id."";
        $permission->item_name = "Mentor";
        $permission->save();
        return $user->save() ? $user : null;
    }

}
