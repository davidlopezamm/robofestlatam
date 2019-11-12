<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EquipoHasCategoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipo-has-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipo_id')->textInput() ?>

    <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'cantidad_actual')->textInput() ?>

    <?= $form->field($model, 'cantidad_maxima')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
