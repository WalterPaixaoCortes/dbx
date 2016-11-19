<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Componentes Visuais';
?>
<div style="text-align: center">
    <h2>Componentes Visuais</h2></br>
    <?php
    if(Yii::$app->getSession()->getFlash('msg') != null){
        echo '<p style="color: #FF0000">'.Yii::$app->getSession()->getFlash('msg').'</p>';
    }
    echo Html::a('<button type="button" class="btn btn-primary">Adicionar</button>', ['componente/upload-visual'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";
    ?>
</div>
<div class="table-responsive" style="padding: 10px">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($componentes as $c) {
            echo '
            <tr>
                <td>'.$c['ID'].'</td>
                <td>'.$c['nome'].'</td>
                <td>'.Html::a("Remover", ['componente/remover-visual', 'componente'=>$c['ID']], ['data' => [
                    'confirm' => "Deseja confirmar a remoção?",
                ]]).'</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>
</div>
