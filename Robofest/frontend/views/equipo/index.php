<?php

use common\models\User;
use yii\helpers\Html;
use \kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EquipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Equipos');
$this->params['breadcrumbs'][] = $this->title;

$rol = "guest";
if (!Yii::$app->user->isGuest) {
    try{
        if (array_key_exists('Administrador', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $rol = "Administrador";
            $columnas = [
                ['class' => 'yii\grid\SerialColumn'],

//            'id',
                [
                    'attribute'=>'user_id',
                    'value'=>'user.username',
                    'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                    'filter'=>\yii\helpers\ArrayHelper::map(User::find()->all(), 'id', 'username'),
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Elige al usuario'],
                ],
                'nombre',
                'cantidad_integrantes',
                [
                    'attribute'=>'id',
                    'value'=>'categoria.nombre',
                    'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                    'filter'=>\yii\helpers\ArrayHelper::map(\frontend\models\Categoria::find()->all(), 'id', 'nombre'),
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Elige al usuario'],
                    'label' => 'Categoría',
                ],



                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}',
                    'buttons' => [
                        'view' =>
                            function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'index.php?r=equipo%2Fview&id='.$model->id, [
                                    'role' => 'button',
                                'class' => 'btn btn-info',
                            ]);
                        },

                        'update' => function ($url, $model) {
                            return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=equipo%2Fupdate&id='.$model->id), 'class' => 'modalButtonEdit btn btn-primary'], [
                                'title' => Yii::t('app', 'Update'),
                            ]);
                        },
                    ],
                ],
            ];
            $columnas2 = [
                ['class' => 'yii\grid\SerialColumn'],

//            'id',
                [
                    'attribute'=>'user_id',
                    'value'=>'user.username',
                    'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                    'filter'=>\yii\helpers\ArrayHelper::map(User::find()->all(), 'id', 'username'),
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Elige al usuario'],
                ],
                [
                    'attribute'=>'id',
                    'label' => 'Institucion de Procedencia',
                    'value'=>'user.institucion_proc',
                ],
                [
                    'attribute'=>'categoria_id',
                    'value'=>'categoria.nombre',
                    'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                    'filter'=>\yii\helpers\ArrayHelper::map(\frontend\models\Categoria::find()->all(), 'id', 'nombre'),
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Elige al usuario'],
                ],
                'cantidad_actual',
                'cantidad_maxima',
            ];
        }
        if (array_key_exists('Mentor', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $rol = "Mentor";
            $columnas = [
                ['class' => 'yii\grid\SerialColumn'],

//            'id',
                'nombre',
                'cantidad_integrantes',
                [
                    'attribute'=>'id',
                    'value'=>function($model){

                        $cat = \frontend\models\EquipoHasCategoria::find()->andFilterWhere(['=', 'equipo_id', $model->id])->one()->categoria->nombre;
                        return $cat;
                    },
                    'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                    'filter'=>\yii\helpers\ArrayHelper::map(\frontend\models\Categoria::find()->all(), 'id', 'nombre'),
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Elige al usuario'],
                    'label' => 'Categoría',
                ],

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}',
                    'buttons' => [
                        'view' =>
                            function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 'index.php?r=equipo%2Fview&id='.$model->id, [
                                    'role' => 'button',
                                    'class' => 'btn btn-info',
                                ]);
                            },

                        'update' => function ($url, $model) {
                            return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=equipo%2Fupdate&id='.$model->id), 'class' => 'modalButtonEdit btn btn-primary'], [
                                'title' => Yii::t('app', 'Update'),
                            ]);
                        },
                    ],
                ],
            ];
            $columnas2 = [
                ['class' => 'yii\grid\SerialColumn'],

//            'id',
                [
                    'attribute'=>'categoria_id',
                    'value'=>'categoria.nombre',
                    'filterType'=> \kartik\grid\GridView::FILTER_SELECT2,
                    'filter'=>\yii\helpers\ArrayHelper::map(\frontend\models\Categoria::find()->all(), 'id', 'nombre'),
                    'filterWidgetOptions'=>['pluginOptions'=>['allowClear'=>true],],
                    'filterInputOptions'=>['placeholder'=>'Elige al usuario'],
                ],
                'cantidad_actual',
                'cantidad_maxima',
            ];
        }
    }catch(Exception $e){
    }
}


?>

<div class="equipo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Comprar Equipo'), ['value' => 'index.php?r=user-has-categoria/create','class' => 'modalButtonView']);?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'filterModel' => $searchModel2,
        'columns' => $columnas2,
    ]); ?>


    <p>
        <?= Html::button(Yii::t('app', 'Crear Equipo'), ['value' => 'index.php?r=equipo/create','class' => 'modalButtonCreate']);?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columnas,
    ]); ?>
</div>
