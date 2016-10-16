<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Componentes';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <?php
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Componentes de Coleta</button>', ['componente/componentes-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Adicionar Componente de Coleta</button>', ['componente/upload-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Componentes de Refinamento</button>', ['componente/upload-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Adicionar Componente de Refinamento</button>', ['componente/upload-refinamento'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Componentes Visuais</button>', ['componente/componentes-visuais'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Adicionar Componente Visual</button>', ['componente/upload-visual'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    ?>

</div>
