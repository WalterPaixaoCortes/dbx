<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Proteínas';
?>
<div class="">
    <?php
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Buscar Proteína</button>', ['proteina/lista'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Adicionar Proteína</button>', ['proteina/adicionar'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    ?>

</div>
