<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $cat int */
/* @var $catN int */
/* @var $ide int */
/* @var $model frontend\models\IntegranteHasCompetenciaHasCategoria */

$this->title = Yii::t('app', 'Update Integrante Has Competencia Has Categoria: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Integrante Has Competencia Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'integrante_id' => $model->integrante_id, 'competencia_has_categoria_id' => $model->competencia_has_categoria_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="integrante-has-competencia-has-categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cat' => $cat,
        'catN' => $catN,
        'ide' => $id,
    ]) ?>

</div>
