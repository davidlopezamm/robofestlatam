<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EquipoHasCategoria */

$this->title = Yii::t('app', 'Update Equipo Has Categoria: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipo Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'equipo_id' => $model->equipo_id, 'categoria_id' => $model->categoria_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="equipo-has-categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
