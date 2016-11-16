<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Pesquisa';
?>

<div style="text-align: center">
    <h2>Proteínas</h2></br>
    <?php
    if(Yii::$app->getSession()->getFlash('msg') != null){
        echo '<p style="color: #FF0000">'.Yii::$app->getSession()->getFlash('msg').'</p>';
    }
    ?>
</div>
<div class="clearfix" style="max-width: 100%; margin: auto ">
    <div style="margin: auto; text-align: center" class="clearfix">
        <?php $form = ActiveForm::begin([
            'id' => 'proteina-form',
        ]); ?>
        <div style="width: 100%; position:relative; float: left">
            <?= $form->field($model, 'nome')->textInput(['value' => $filtro['nome']])->label("Nome") ?>
        </div>
        <div style="width: 100%; position:relative; float: left;">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary',]) ?>
            <?php echo Html::a('<button type="button" class="btn btn-primary">Adicionar</button>', ['proteina/adicionar'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br>";?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="">
    <div class="table-responsive" style="padding: 10px; background-color: #fafafa; margin: 10px">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <?php if(!Yii::$app->user->isGuest){
                    echo "<th style='width: 30%'>Ações</th>";
                } ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $acoes;
            foreach ($proteinas as $p){
                $acoes = (Yii::$app->user->isGuest ? '':'<td>'.Html::a("Remover", ['proteina/remover', 'proteina'=>$p['id']]).'</td>');
                echo '<tr>
                            <td>' . $p['nome'] . '</td>'.$acoes.'
                          </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="clearfix" style="margin: auto">
        <ul class="pagination pagination-sm" style="margin: auto">
            <?php
            if($filtro['pags'] > 1) {
                $i = 0;
                $max = 0;
                if ($filtro['pags'] <= 7) {
                    $i = 1;
                    $max = $filtro['pags'];
                } else {
                    if ($filtro['pag'] < 4) {
                        $i = 1;
                        $max = 7;
                    } else {
                        if (($filtro['pag'] + 3) > $filtro['pags']) {
                            $max = $filtro['pags'];
                            $i = $max - 6;
                        } else {
                            $i = $filtro['pag'] - 3;
                            $max = $filtro['pag'] + 3;
                        }
                    }
                }
                echo '  <li>' . Html::a(($filtro['pag']==1?"<b>Primeira</b>":"Primeira"), ['proteina/lista', 'pag' => 1, 'nome' => $filtro['nome']]) . '</li>';
                if ($i <= 1) {
                    $i++;
                }
                for (; $i < $max; $i++) {
                    echo '<li>' . Html::a(($i == $filtro['pag'] ? "<b>" . $i . "</b>" : $i), ['proteina/lista', 'pag' => $i, 'nome' => $filtro['nome']]) . '</li>';
                }
                echo '  <li>' . Html::a(($filtro['pag']==$filtro['pags']?"<b>Última - " . $filtro['pags']."</b>":"Última - " . $filtro['pags']), ['proteina/lista', 'pag' => $filtro['pags'], 'nome' => $filtro['nome']]) . '</li>';
            }
            ?>
        </ul>
    </div>
</div>

