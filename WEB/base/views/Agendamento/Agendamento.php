<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\jui;
use yii\jui\Sortable;

$this->title = 'Agendamento';
$componentes = [
    ['content' => 'e', 'options' => ['value' => 'c5']],
    ['content' => 'f', 'options' => ['value' => 'c6']],
    ['content' => 'g', 'options' => ['value' => 'c7']],
    ['content' => 'h', 'options' => ['value' => 'c8']],
    ['content' => 'i', 'options' => ['value' => 'c9']],
    ['content' => 'j', 'options' => ['value' => 'c10']],
];
$lista = [
    ['content' => 'a', 'options' => ['value' => 'c1']],
    ['content' => 'b', 'options' => ['value' => 'c2']],
    ['content' => 'c', 'options' => ['value' => 'c3']],
    ['content' => 'd', 'options' => ['value' => 'c4']],
];

$form = ActiveForm::begin([
    'id' => 'agendamento-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-3\">{input}</div><div class=\"col-lg-9\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-1 control-label'],
    ],
]);

echo Html::hiddenInput("ordem", "", ['id' => 'ordemComponentes']);
?>
<div style="text-align: center">

    <?= $form->field($model, 'nome')->textInput(); ?>
    <?= $form->field($model, 'comentario')->textarea(["rows"=>10]); ?>
    <div class="form-group">
        <label class="col-lg-1 control-label" for="agendamentoform-comentario">Início</label>
        <div class="col-lg-3" style="text-align: left"><?= jui\DatePicker::widget(['model'=>$model, 'attribute'=>'inicio', 'dateFormat' => 'dd/MM/yyyy','language' => 'pt-br',]);?></div>
    </div>
    <?= $form->field($model, 'id')->hiddenInput()->label(""); ?>

    <div class="table-responsive">
    <table style="border: 1px solid; text-align: center; margin: auto !important; max-width: 640px;" class="table table-hover">
        <tr>
            <th style=" border: 1px solid; text-align: center">
                Componentes Disponíveis
            </th>
            <th style=" border: 1px solid; text-align: center">
                Componentes Selecionados
            </th>
        </tr>
        <tr>
            <td style="padding: 20px !important; border: 1px solid">
                <?php
                echo Sortable::widget([
                    'items' => $componentes,
                    'options' => ['tag' => 'ul', 'style' => 'padding: 0px !important', 'class' => 'connectedSortable'],
                    'itemOptions' => ['tag' => 'li', 'style' => 'width: 300px; margin-top: 5px; border: 1px solid; border-radius: 5px; text-align: center', 'class' => 'alert-info'],
                    'clientOptions' => ['cursor' => 'move', 'connectWith' => '.connectedSortable'],
                ]);
                ?>
            </td>
            <td style="padding: 20px !important">
                <?php
                echo Sortable::widget([
                    'id' => 'olComponentes',
                    'items' => $lista,
                    'options' => ['tag' => 'ol', 'style' => 'padding: 0px !important', 'class' => 'connectedSortable'],
                    'itemOptions' => ['tag' => 'li', 'style' => 'width: 300px; margin-top: 5px; border: 1px solid; border-radius: 5px; text-align: center', 'class' => 'alert-info'],
                    'clientOptions' => ['cursor' => 'move', 'connectWith' => '.connectedSortable'],
                ]);
                ?>
            </td>
        </tr>
    </table>
</div>
    </br>
    <?php
    echo '<div class="form-group" style="width: 100%; margin: auto !important;">' . Html::button("Salvar", ["class" => "btn btn-primary",
            "onClick" => "{
    document.getElementById('ordemComponentes').value = '';
    var a = document.getElementById('olComponentes').children;
        var ordem = '';
    for(var i = 0; i < a.length; i++){
        console.log(a[i].attributes['value']);
        ordem += a[i].attributes['value'].value+';';
    }
    document.getElementById('ordemComponentes').value = ordem;
    document.getElementById('agendamento-form').submit();
}"]) . '</div>';
    ?>
</div>
    <?php
    ActiveForm::end();
    ?>
