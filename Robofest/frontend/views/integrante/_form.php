<?php

use frontend\models\Categoria;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Integrante */
/* @var $form yii\widgets\ActiveForm */
/* @var $edad_min int */
/* @var $edad_max int */
?>

<div class="integrante-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row-">
        <div class="col-lg-6">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'correo')->textInput(['maxlength' => true,
    'onchange' => '
                                            var element = $(this);
                                                $.post("index.php?r=equipo/val-correo&correo="'.'+$(this).val(), function( data ){
                                                    if(data){
                                                        alert("Correo seleccionado por otro usuario");
                                                        element.val("");
                                                    }
                                                    });',]) ?>
        </div>
    </div>

    <div class="row-">
        <div class="col-lg-6">
            <?= $form->field($model, 'edad')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => "dd-M-yyyy",
                'language' => 'es',

                'clientOptions' => [

                    'changeMonth' => true,

                    'changeYear' => true,
                ],
                'options' => [
                    'class' => 'form-control picker edad',
                    'placeholder' => Yii::t('app', 'Fecha de nacimiento'),
                    'onchange' =>'
                        var element = $(this);
                        $.post("index.php?r=integrante/val-edad&edad="'.'+$(this).val()+"&edad_min='.$edad_min.'&edad_max='.$edad_max.'", function( data ){
                            if(data != 1){
                                alert("Edad no valida para la categorí escogida.");
                                element.val("");
                            }
                    });',],
                ]) ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'genero')->widget(\kartik\select2\Select2::classname(), [
                'data' => ['Hombre' => 'Hombre', 'Mujer' => 'Mujer', 'Otro' => 'Otro'],
                'options' => [
                    'placeholder' => Yii::t('app', 'Selecciona tú género'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>

    <?php
    if ($model->isNewRecord) {
        ?>
        <p>
            <input type="checkbox" required id="queue-order" value="1"> Acepta nuestros términos y condiciones.
        </p>
        <?php
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
