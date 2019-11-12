<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Integrante */
/* @var $edad_min int */
/* @var $edad_max int */

$this->title = Yii::t('app', 'Crear Integrante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Integrantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integrante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'edad_min' => $edad_min,
        'edad_max' => $edad_max,
    ]) ?>

</div>
