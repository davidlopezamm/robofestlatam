<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'enableAjaxValidation' => true]); ?>

            <div class="col-lg-3">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nombre') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'age')->widget(
                            DatePicker::className(), [
                            // inline too, not bad
//        'inline' => true,
                            'language' => 'es_ES',
                            'value' => 'dd-mm-yyyy',
                            // modify template for custom rendering
//        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ])->label('Edad') ?>
            </div>
            <div class="col-lg-3">
                <?=
                $form->field($model, 'genre')->widget(\kartik\select2\Select2::classname(), [
                    'data' => ['Hombre' => 'Hombre', 'Mujer' => 'Mujer', 'Otro' => 'Otro'],
                    'options' => [
                        'placeholder' => Yii::t('app', 'Selecciona tú género'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Género');
                ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'institucion_proc')->textInput()->label('Institución de Procedencia') ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-4">
                <?= $form->field($model, 'email')->textInput([
                    'enableAjaxValidation' => true,
                ]) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
            </div>
        </div>
    </div>
    <p>
        <input type="checkbox" required id="queue-order" value="1"> Acepta nuestros términos y condiciones.
    </p>
    <div class="row">
            <div class="col-lg-12">

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
