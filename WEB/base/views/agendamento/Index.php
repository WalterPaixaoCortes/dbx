<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\Button;

$this->title = 'Agendamento';
?>

<div class="">
    <?php
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Listar Agendamentos</button>', ['agendamento/lista'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    echo Html::a('<button type="button" class="btn btn-primary btn-block">Adicionar Agendamento</button>', ['agendamento/adicionar'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    ?>

</div>
