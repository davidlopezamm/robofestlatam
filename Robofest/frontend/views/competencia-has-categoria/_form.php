<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Competencia;
use frontend\models\Categoria;

/* @var $this yii\web\View */
/* @var $model frontend\models\CompetenciaHasCategoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competencia-has-categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?=
            $form->field($model, 'Competencia_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(Competencia::find()->all(),
                    'id', 'nombre'),
                'options' => [
                    'placeholder' => Yii::t('app', 'Elige la competencia'),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-lg-6">
            <?=
            $form->field($model, 'categoria_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(Categoria::find()->all(),
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
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
