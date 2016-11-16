<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Estrutura';

if (!isset($estrutura['proteina'])) {
    echo '
<div class="jumbotron" style="color: #ff0000">
    <h4>Estrutura não encontrada</h4>
</div>';
} else {
    ?>
    <div>
        <?php
        try {
            $a = file_get_contents(Yii::$app->basePath . "/../../BackgroundServices/Componentes/Visual/" . $estrutura['componentevisual'] . ".html");

            foreach ($estrutura['estrutura'] as $k => $v) {
                $a = str_replace("{{" . strtoupper($k) . "}}", $v, $a);

                if(stripos($a,"{{TABELA;".strtoupper($k)."}}") == false){
                    continue;
                }

                if($v != ""){
                    $tabela = "<div class='table-responsive'><table style='border: 1px solid; width: 100%' class='table table-hover'><tr>";
                    $dados = json_decode($estrutura['estrutura'][$k]);
                    foreach ($dados->colunas as $coluna){
                        $tabela .= "<th style='border: 1px solid'>".$coluna."</th>";
                    }
                    foreach ($dados->valores as $valores){
                        $tabela .= "</tr><tr style='border: 1px solid'>";
                        foreach ($valores as $valor){
                            $tabela .= "<td style='border: 1px solid'>".$valor."</td>";
                        }
                    }
                    $tabela .= "</tr></table></div>";
                    $a = str_replace("{{TABELA;".strtoupper($k)."}}",$tabela,$a);
                    continue;
                }
                $a = str_replace("{{TABELA;".strtoupper($k)."}}","",$a);
            }
            echo $a;
        } catch (Exception $e) {
            echo '<p style="text-align: center; color: #ff0000">Erro ao tentar carregar o componente visual.</p>';
        }
        ?>
    </div>
<?php } ?>