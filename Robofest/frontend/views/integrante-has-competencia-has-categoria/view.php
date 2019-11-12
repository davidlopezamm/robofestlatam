<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $provider \yii\data\ArrayDataProvider */

$this->title = $provider->allModels[0]['competencia'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Integrante Has Competencia Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="integrante-has-competencia-has-categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $provider->allModels[0],
        'attributes' => [
            'competencia',
            'integrantes',
        ],
    ]) ?>

</div>
