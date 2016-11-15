<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Componentes Coleta';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div style="text-align: center">
    <h2>Componentes de Refinamento</h2></br>
    <?php
    if(Yii::$app->getSession()->getFlash('msg') != null){
        echo '<p style="color: #FF0000">'.Yii::$app->getSession()->getFlash('msg').'</p>';
    }
    echo Html::a('<button type="button" class="btn btn-primary">Adicionar</button>', ['componente/upload-refinamento'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    ?>
</div>
<div class="table-responsive" style="padding: 10px">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Criação</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($componentes as $c) {
            echo '
            <tr>
                <td>'.$c['Nome'].'</td>
                <td>'.$c['Criacao'].'</td>
                <td>'.Html::a("Remover", ['componente/remover-refinamento', 'componente'=>$c['ID']]).' </td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</div>
