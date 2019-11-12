<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head();


$rol = "guest";
if (!Yii::$app->user->isGuest) {
    try{
        if (array_key_exists('Administrador', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $rol = "Administrador";
        }
        if (array_key_exists('Mentor', \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            $rol = "Mentor";
        }
    }catch(Exception $e){
    }
}?>

</head>
<body>

<?php
Modal::begin([
    'id' => 'edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false,
    ],
]);

echo "<div id='editContent'></div>";

Modal::end();
?>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => "Robofest",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Inicio', 'url' => ['/site/index']],
        ($rol == "Mentor"||$rol == "Administrador")?
            ['label' => 'Equipos', 'url' => ['/equipo']]:'',
        $rol == "Administrador"?
            ['label' => 'Competencias y Categorías', 'items' => [
                ['label' => 'Competencias y Categorías', 'url' => ['/competencia-has-categoria']],
                ['label' => 'Competencias', 'url' => ['/competencia']],
                ['label' => 'Categorías', 'url' => ['/categoria']]
            ]]:'',
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
