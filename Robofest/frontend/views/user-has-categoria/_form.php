<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserHasCategoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-has-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'categoria_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\frontend\models\Categoria::find()->all(),
                    'id', 'nombre'),
                'options' => [
                    'placeholder' => Yii::t('app', 'Elige la categoria'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'cantidad_maxima')->textInput(['type' => 'number'])->label('¿Cuántas quieres comprar?') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Comprar'), ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
