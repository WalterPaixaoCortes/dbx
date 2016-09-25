<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Coponentes Coleta';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div style="text-align: center">
    <h2>Componentes de Coleta</h2></br>
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
                <td>Editar/Remover</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</div>
