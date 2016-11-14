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
<div class="" style="text-align: center !important; margin: auto; margin-top: 10vh !important; max-width: 600px">
    <?php
    echo Html::a('<button type="button" class="btn btn-primary">Componentes de Coleta</button>', ['componente/componentes-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br></br>";
//    echo Html::a('<button type="button" class="btn btn-primary col-lg-5">Adicionar Componente de Coleta</button>', ['componente/upload-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary">Componentes de Refinamento</button>', ['componente/upload-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br></br>";
//    echo Html::a('<button type="button" class="btn btn-primary col-lg-5">Adicionar Componente de Refinamento</button>', ['componente/upload-refinamento'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary">Componentes Visuais</button>', ['componente/componentes-visuais'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br></br>";
//    echo Html::a('<button type="button" class="btn btn-primary col-lg-5">Adicionar Componente Visual</button>', ['componente/upload-visual'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    ?>

</div>
