<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Componentes Coleta';
?>
<div style="text-align: center">
    <h2>Componentes de Coleta</h2></br>
    <?php
    if(Yii::$app->getSession()->getFlash('msg') != null){
        echo '<p style="color: #FF0000">'.Yii::$app->getSession()->getFlash('msg').'</p>';
    }
    echo Html::a('<button type="button" class="btn btn-primary">Adicionar</button>', ['componente/upload-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
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
                <td>'.Html::a("Configurar", ['componente/editar-coleta', 'componente'=>$c['Nome']]).'/ '.Html::a("Remover", ['componente/remover-coleta', 'componente'=>$c['ID']], ['data' => [
                    'confirm' => "Deseja confirmar a remoção?",
                ]]).' </td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</div>
