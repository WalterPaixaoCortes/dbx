<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap container" style="background-color: #f0f0f0;">
    <?php
    NavBar::begin([
        'brandLabel' => 'DB-X',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default  navbar-fixed-top',
            'style' => 'background-color: #d3f2ff;'
        ],
    ]);

    $itens = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'Estruturas', 'url' => ['/proteina/busca']],
        ['label' => 'Artigos', 'url' => ['/artigo/index']],
        ['label' => 'Sobre', 'url' => ['/site/sobre']]
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $itens,
    ]);
    if(!Yii::$app->user->isGuest){
        $itens = [
            ['label' => 'Componentes', 'url' => ['componente/index']],
            ['label' => 'Proteínas', 'url' => ['proteina/index']]
        ];
        $itens[] = '<li>'. Html::beginForm(['/login/logout'], 'post', ['class' => 'navbar-form  navbar-right'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $itens,
        ]);
    }
    NavBar::end();
    ?>

    <div class="container">
        <?= $content ?>
    </div>
    <div style="width: 100%; background-color: #d3f2ff; text-align: center; font-size: smaller" class="navbar-fixed-bottom">
        DB-X PUCRS-<?php echo date('Y') ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
