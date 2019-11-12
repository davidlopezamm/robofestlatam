<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EquipoHasCategoriaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipo-has-categoria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'equipo_id') ?>

    <?= $form->field($model, 'categoria_id') ?>

    <?= $form->field($model, 'cantidad_actual') ?>

    <?= $form->field($model, 'cantidad_maxima') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
