<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CompetenciaHasCategoria */

$this->title = Yii::t('app', 'Crear Competencia Tiene Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competencia Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competencia-has-categoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
