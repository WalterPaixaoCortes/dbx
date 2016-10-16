<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

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
        <div style="width: 50%; position:relative; float: left">
            <?= $form->field($model, 'nome')->textInput(['value' => $filtro['nome']])->label("Nome") ?>
        </div>
        <div style="width: 50%; position:relative; float: left">
            <?= $form->field($model, 'estrutura')->textInput(['value' => $filtro['estrutura']])->label("Estrutura") ?>
        </div>
        <div style="width: 100%; position:relative; float: left;">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary',]) ?>
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
                <th>Estrutura</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($proteinas as $p){
                echo '<tr>
                            <td>' . Html::a($p['nome'], ['proteina/visualizar-estrutura', 'componente'=>$p['idComponente'], 'estrutura'=>$p['idEstrutura']]). '</td>'.'<td>' . Html::a($p['estrutura'], ['proteina/visualizar-estrutura', 'componente'=>$p['idComponente'], 'estrutura'=>$p['idEstrutura']]). '</td>
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

