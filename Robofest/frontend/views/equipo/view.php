<?php

use frontend\models\Equipo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Equipo */
/* @var $equipo int */
/* @var $edad_min int */
/* @var $edad_max int */
/* @var $provider \yii\data\ArrayDataProvider */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="equipo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'nombre',
            'cantidad_integrantes',
            [
                'attribute' => 'user_id',
                'value' => $model->user->username,
            ],
            [
                'label' => 'Categoria',
                'value' => function($model){

                    $cat = \frontend\models\EquipoHasCategoria::find()->andFilterWhere(['=', 'equipo_id', $model->id])->one()->categoria->nombre;
                    return $cat;
                },
            ],
        ],
    ]) ?>

    <h2 style="text-align: center"><b>Integrantes</b></h2>

    <p>
        <?= Html::button(Yii::t('app', 'Crear integrante'), ['value' => 'index.php?r=integrante/create&ide='.$equipo.'&edad_min='.$edad_min.'&edad_max='.$edad_max,'class' => 'modalButtonCreate']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//
            'nombre',
            'correo',
            [
                'attribute' => 'edad',
                'value' => function($model){
                    return date('d-m-Y', strtotime($model->edad ));
                },
            ],
            'genero',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=integrante%2Fview&id='.$model->id), 'class' => 'modalButtonView btn btn-primary'], [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },

                    'update' => function ($url, $model) use ($edad_min, $edad_max) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=integrante%2Fupdate&id=' . $model->id.'&edad_min='.$edad_min.'&edad_max='.$edad_max), 'class' => 'modalButtonEdit btn btn-primary'], [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>


    <h2 style="text-align: center"><b>Competencias</b></h2>

    <p>
        <?= Html::button(Yii::t('app', 'inscribirse a una competencia'), ['value' => 'index.php?r=integrante-has-competencia-has-categoria/create&ide='.$equipo,'class' => 'modalButtonCreate']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
//
            'competencia',
            'integrantes',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=integrante-has-competencia-has-categoria%2Fview&id='.$model["equipo_id"].'&idc='.$model["competencia_has_categoria_id"]."&rid=".$model["rid"]), 'class' => 'modalButtonView btn btn-primary'], [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },
/*                    'edit' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=integrante-has-competencia-has-categoria%2Fupdate&id='.$model["equipo_id"].'&idc='.$model["competencia_has_categoria_id"]."&rid=".$model["rid"]), 'class' => 'modalButtonEdit btn btn-primary'], [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },*/

                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'index.php?r=integrante-has-competencia-has-categoria%2Fdelete&rid='.$model["rid"], [
                            'data-method' => 'POST',
                            'title' => Yii::t('app', 'Delete'),
                            'data-confirm' => "¿Seguro que desea eliminar a los integrantes de esta competencia?",
                            'role' => 'button',
                            'class' => 'modalButtonDelete',
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>

</div>



