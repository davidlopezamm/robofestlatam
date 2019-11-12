<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cat int */
/* @var $ide int */
/* @var $catN string */
/* @var $model frontend\models\IntegranteHasCompetenciaHasCategoria */


$this->title = Yii::t('app', 'Inscribir equipo a competencia, categoría: '.$catN);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Integrante Has Competencia Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integrante-has-competencia-has-categoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cat' => $cat,
        'ide' => $ide,
    ]) ?>

</div>
