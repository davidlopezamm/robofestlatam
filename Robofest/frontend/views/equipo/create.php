<?php

use frontend\models\Integrante;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Equipo */

$this->title = Yii::t('app', 'Crear Equipo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelIntegrantes' => (empty($modelIntegrantes)) ? [new Integrante()] : $modelIntegrantes
    ]) ?>

</div>
