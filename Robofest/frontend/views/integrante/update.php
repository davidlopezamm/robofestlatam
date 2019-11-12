<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $edad_min int */
/* @var $edad_max int */

$this->title = Yii::t('app', 'Actualizar Integrante: {name}', [
    'name' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Integrantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="integrante-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'edad_min' => $edad_min,
        'edad_max' => $edad_max,
    ]) ?>

</div>
