<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\CompetenciaHasCategoria */

$this->title = $model->competencia->nombre." con ".$model->categoria->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competencia Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="competencia-has-categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            [
                'attribute' => 'Competencia_id',
                'value' => $model->competencia->nombre,
            ],
            [
                'attribute' => 'categoria_id',
                'value' => $model->categoria->nombre,
            ],
        ],
    ]) ?>

</div>
