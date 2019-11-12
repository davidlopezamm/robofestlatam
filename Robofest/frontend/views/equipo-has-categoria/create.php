<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EquipoHasCategoria */

$this->title = Yii::t('app', 'Create Equipo Has Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipo Has Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipo-has-categoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
