<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CompetenciaHasCategoria */

$this->title = Yii::t('app', 'Actualizar Competencia Tiene Categoria: {name}', [
    'name' => $model->competencia->nombre." con ".$model->categoria->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competencia Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'Competencia_id' => $model->Competencia_id, 'categoria_id' => $model->categoria_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="competencia-has-categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
