<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\jui;
use yii\jui\Sortable;

$this->title = 'Componente de Coleta';

$form = ActiveForm::begin([
    'id' => 'coleta-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div><div class=\"col-lg-12\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-12 control-label', 'style' => 'text-align: center !important'],
    ],
]);
?>

<div style="text-align: center">
    <h2>Componente <?php echo $model->nome;?></h2></br>
    <?php
    if (Yii::$app->getSession()->getFlash('msg') != null) {
        echo '<p style="color: #FF0000">' . Yii::$app->getSession()->getFlash('msg') . '</p>';
    }
    ?>
</div>
<div style="text-align: center">

    <div style="position: relative; text-align: center" class="col-lg-12">
        <div style="position: relative; text-align: center; margin: auto; max-width: 500px" class="">
            <?php
            $lista = ["1"=>"a"];
            $lista[0] = "Nenhum";
            foreach ($visuais as $v){
                $lista[$v['ID']] = $v['nome'];
            }
            ?>
            <?= $form->field($model, 'visual')->dropDownList($lista)->label("Componente Visual") ?>
            <?= $form->field($model, 'nome')->hiddenInput()->label(""); ?>
            <h5><b>Proteínas:</b></h5>
            <?php
            foreach ($model->proteinas as $p=>$v){
                echo '<input type="checkbox" name="proteina[]" id="proteina_'.$p.'" value="'.$p.'" '.($v?"checked":"").'>'.$p.'<br>';
            }
            ?>
    </div>
    <div class="col-lg-12" style="margin-top: 25px">
        <div>
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary', 'name' => 'salvar-button']) ?>
        </div>
    </div>

</div>

<?php
ActiveForm::end();
?>