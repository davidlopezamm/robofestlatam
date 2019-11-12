<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\helpers\Url;
use frontend\models\Competencia;
use kartik\grid\GridView;
use frontend\models\Categoria;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CompetenciaHasCategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Competencia Has Categorias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competencia-has-categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Crear Competencia con Categoría'), ['value' => 'index.php?r=competencia-has-categoria/create','class' => 'modalButtonCreate']);?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute'=>'Competencia_id',
                'value'=>'competencia.nombre',
                'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                'filter'=>\yii\helpers\ArrayHelper::map(Competencia::find()->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                'filterInputOptions'=>['placeholder'=>'Elige la competencia'],
            ],
            [
                'attribute'=>'categoria_id',
                'value'=>'categoria.nombre',
                'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                'filter'=>\yii\helpers\ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                'filterInputOptions'=>['placeholder'=>'Elige la competencia'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=competencia-has-categoria%2Fview&Competencia_id='.$model->Competencia_id.'&categoria_id='.$model->categoria_id.'&id='.$model->id), 'class' => 'modalButtonView btn btn-primary'], [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value'  => Url::to('index.php?r=competencia-has-categoria%2Fupdate&Competencia_id='.$model->Competencia_id.'&categoria_id='.$model->categoria_id.'&id='.$model->id), 'class' => 'modalButtonEdit btn btn-primary'], [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
