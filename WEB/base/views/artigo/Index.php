<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Artigos';
?>

<div style="text-align: center">
    <h2>Artigos</h2></br>
</div>
<div class="clearfix" style="max-width: 100%; margin: auto ">
    <div style="margin: auto; text-align: center" class="clearfix">
        <?php $form = ActiveForm::begin([
            'id' => 'artigo-form',
        ]); ?>
        <div style="width: 35%; position:relative; float: left">
            <?= $form->field($model, 'titulo')->textInput(['value' => $filtro['titulo']])->label("Título") ?>
        </div>
        <div style="width: 30%; position:relative; float: left">
            <?= $form->field($model, 'proteina')->textInput(['value' => $filtro['proteina']])->label("Proteína") ?>
        </div>
        <div style="width: 35%; position:relative; float: left">
            <?= $form->field($model, 'autor')->textInput(['value' => $filtro['autor']])->label("Autor") ?>
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

            <?php
            if (empty($artigos)) {
                echo "<p style='text-align: center'>Nenhum resultado encontrado.</p>";
            } else {
                ?>
                <thead>
                <tr>
                    <th>Artigo</th>
                    <th>Data</th>
                    <th>Proteína</th>
                    <th>Abstract</th>
                    <th>Autor(es)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = -1;
                $artigo = null;
                foreach ($artigos as $a) {
                    if ($id == $a['id']) {
                        $artigo['autor'] = $artigo['autor'] . "; " . $a['autor'];
                    } else {
                        if ($artigo != null) {
                            echo '<tr>
                            <td><a href="' . $artigo['link'] . '" target="_blank">' . $artigo['titulo'] . '</a></td>
                            <td>' . ($artigo['data']=="0000-00-00"?" - ":date("d/m/Y", strtotime($artigo['data']))) . '</td>
                            <td>' . ($artigo['proteina'] == null ? " - " : $artigo['proteina']) . '</td>
                            <td>' . ($artigo['abstract'] == null ? " - " : '<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal' . $a['id'] . '">Ler</button>
                                <div id="myModal' . $a['id'] . '" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title" style="text-align: center">' . $artigo['titulo'] . ' - Abstract<h4>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-indent: 20px; text-align: justify; max-width: 100% !important; height: 100%; position: relative">' . $artigo['abstract'] . '</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>') . '</td>
                            <td>' . $artigo['autor'] . '</td>                                
                        </tr>';
                        }
                        $artigo = $a;
                        $id = $a['id'];
                    }
                }
                if ($artigo != null) {
                    $id++;
                    echo '<tr>
                            <td><a href="' . $artigo['link'] . '" target="_blank">' . $artigo['titulo'] . '</a></td>
                            <td>' . ($artigo['data']=="0000-00-00"?" - ":date("d/m/Y", strtotime($artigo['data']))). '</td>
                            <td>' . ($artigo['proteina'] == null ? " - " : $artigo['proteina']) . '</td>
                            <td>' . ($artigo['abstract'] == null ? " - " : '<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal-' . $id . '">Ler</button>
                                <div id="myModal-' . $id . '" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title" style="text-align: center">' . $artigo['titulo'] . ' - Abstract<h4>
                                            </div>
                                            <div class="modal-body">
                                                <div style="text-indent: 20px; text-align: justify; max-width: 100% !important; height: 100%; position: relative">' . $artigo['abstract'] . '</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                
                                    </div>
                                </div>') . '</td>
                            <td>' . $artigo['autor'] . '</td>                                
                        </tr>';
                }

                ?>
                </tbody>
            <?php } ?>
        </table>
    </div>
</div>
<div class="clearfix" style="margin: auto">
    <ul class="pagination pagination-sm" style="margin: auto">
        <?php
        if ($filtro['pags'] > 1) {
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
            echo '  <li>' . Html::a(($filtro['pag'] == 1 ? "<b>Primeira</b>" : "Primeira"), ['artigo/index', 'pag' => 1, 'titulo' => $filtro['titulo'], 'proteina' => $filtro['proteina'], 'autor' => $filtro['autor']]) . '</li>';
            if ($i <= 1) {
                $i++;
            }
            for (; $i < $max; $i++) {
                echo '<li>' . Html::a(($i == $filtro['pag'] ? "<b>" . $i . "</b>" : $i), ['artigo/index', 'pag' => $i, 'titulo' => $filtro['titulo'], 'proteina' => $filtro['proteina'], 'autor' => $filtro['autor']]) . '</li>';
            }
            echo '<li>' . Html::a(($filtro['pag'] == $filtro['pags'] ? "<b>Última - " . $filtro['pags'] . "</b>" : "Última - " . $filtro['pags']), ['artigo/index', 'pag' => $filtro['pags'], 'titulo' => $filtro['titulo'], 'proteina' => $filtro['proteina'], 'autor' => $filtro['autor']]) . '</li>';
        }
        ?>
    </ul>
</div>
