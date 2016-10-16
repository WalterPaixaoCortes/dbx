<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Estrutura';
?>

<div class="jumbotron">
    <h3><?php echo $estrutura['proteina']." - ".$estrutura['estrutura']['estrutura'] ?></h3>
</div>
<div>
    <?php
        try {
            $a = file_get_contents(Yii::$app->basePath . "/../../Componentes/Visual/" . $estrutura['componentevisual'] . ".html");
            foreach ($estrutura['estrutura'] as $k=>$v){
                $a = str_replace("{{".strtoupper($k)."}}",$v,$a);
            }
            echo $a;
        }catch(Exception $e){
            echo '<p style="text-align: center; color: #ff0000">Erro ao tentar carregar o componente visual.</p>';
        }
    ?>
</div>
