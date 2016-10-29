<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

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
            $a = file_get_contents(Yii::$app->basePath . "/../../Componentes/Visual/" . $estrutura['componentevisual'] . ".html");
            $a = str_replace("{{DBX-URL}}", Yii::$app->params['url'], $a);
            foreach ($estrutura['estrutura'] as $k => $v) {
                $a = str_replace("{{" . strtoupper($k) . "}}", $v, $a);
            }
            echo $a;
        } catch (Exception $e) {
            echo '<p style="text-align: center; color: #ff0000">Erro ao tentar carregar o componente visual.</p>';
        }
        ?>
    </div>
<?php } ?>