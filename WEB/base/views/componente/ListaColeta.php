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
    <h2>Componentes de Coleta</h2></br>
    <?php
    if(Yii::$app->getSession()->getFlash('msg') != null){
        echo '<p style="color: #FF0000">'.Yii::$app->getSession()->getFlash('msg').'</p>';
    }
    ?>
</div>
<div class="table-responsive" style="padding: 10px">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Tabela</th>
            <th>Criação</th>
            <th>Última Alteração</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($componentes as $c) {
            echo '
            <tr>
                <td>'.$c['ID'].'</td>
                <td>'.$c['Nome'].'</td>
                <td>'.$c['NomeTabela'].'</td>
                <td>'.$c['Criacao'].'</td>
                <td>'.$c['Alteracao'].'</td>
                <td>'.Html::a("Remover", ['componente/remover-coleta', 'componente'=>$c['ID']]).' / Editar</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</div>
