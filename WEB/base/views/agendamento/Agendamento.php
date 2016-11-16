<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\jui;
use yii\jui\Sortable;

$this->title = 'Agendamento';

$componentesDisponiveis = [];
$componentesSelecionados = [];

foreach ($componentes as $componente){
    $componentesDisponiveis[] = ['content' => $componente->Nome, 'options' => ['value' => $componente->ID]];
}
foreach ($selecionados as $selecionado){
    foreach ($componentesDisponiveis as $i=>$componente){
        if($componente['options']['value'] == $selecionado){
            $componentesSelecionados[] = $componente;
            unset($componentesDisponiveis[$i]);
            break;
        }
    }
}

$form = ActiveForm::begin([
    'id' => 'agendamento-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-12\">{input}</div><div class=\"col-lg-12\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-12 control-label', 'style' => 'text-align: left !important'],
    ],
]);

echo Html::hiddenInput("ordem", "", ['id' => 'ordemComponentes']);

if ($model->inicio == '') {
    $model->inicio = date("d/m/Y");
}
$hora = [];
$i = 00;
for (; $i < 24; $i++) {
    $i = ($i < 10 ? "0" . $i : $i);
    $hora[$i] = $i;
}
$min = $hora;
for (; $i < 60; $i++) {
    $min[$i] = $i;
}
?>

<div style="text-align: center">
    <h2>Agendamento</h2></br>
    <?php
    if (Yii::$app->getSession()->getFlash('msg') != null) {
        echo '<p style="color: #FF0000">' . Yii::$app->getSession()->getFlash('msg') . '</p>';
    }
    ?>
</div>
<div style="text-align: center">

    <div style="position: relative; text-align: center" class="col-lg-4">
        <?= $form->field($model, 'nome')->textInput(); ?>
        <?= $form->field($model, 'comentario')->textarea(["rows" => 10, 'maxLength' => 255])->label("Comentário"); ?>
        <?= $form->field($model, 'paralelismo')->checkbox()->label("Paralelismo"); ?>
        <?= $form->field($model, 'inicio')->widget(\yii\jui\DatePicker::classname(), ['model' => $model, 'attribute' => 'inicio', 'dateFormat' => 'dd/MM/yyyy', 'language' => 'pt-br', 'options' => ['class' => 'col-lg-3 form-control']])->label("Início"); ?>
        <div style="text-align: left">
            <?= $form->field($model, 'hora')->dropDownList($hora)->label("Hora início") ?>
            <?= $form->field($model, 'minuto')->dropDownList($min)->label("Minutos início") ?>
        </div>
        <div style="text-align: left">
            <?= $form->field($model, 'intervalo')->widget(\yii\jui\Spinner::classname(), ['options' => ['style' => 'width: 80px; padding: 2px'], 'clientOptions' => ['step' => 1]])->label("Intervalo (dias)"); ?>
        </div>
        <?= $form->field($model, 'id')->hiddenInput()->label(""); ?>
    </div>
    <div class="table-responsive col-lg-8" style="margin-top: 25px">
        <table
            style="border: 1px solid #cccccc; border-radius: 4px; text-align: center; margin: auto !important; max-width: 640px; background-color: #ffffff"
            class="table table-hover">
            <tr>
                <th style=" border: 1px solid #cccccc; border-radius: 4px; text-align: center">
                    Componentes Disponíveis
                </th>
                <th style=" border: 1px solid #cccccc; border-radius: 4px; text-align: center">
                    Componentes Selecionados
                </th>
            </tr>
            <tr>
                <td style="padding: 20px !important; border: 1px solid #cccccc; border-radius: 4px;">
                    <?php
                    echo Sortable::widget([
                        'items' => $componentesDisponiveis,
                        'options' => ['tag' => 'ul', 'style' => 'padding: 20px 10px 20px 10px !important; list-style-type:none', 'class' => 'connectedSortable alert alert-warning'],
                        'itemOptions' => ['tag' => 'li', 'style' => 'width: 300px; margin-top: 5px; border: 1px solid; border-radius: 5px; text-align: center; ', 'class' => 'alert-info'],
                        'clientOptions' => ['cursor' => 'move', 'connectWith' => '.connectedSortable'],
                    ]);
                    ?>
                </td>
                <td style="padding: 20px !important">
                    <?php
                    echo Sortable::widget([
                        'id' => 'olComponentes',
                        'items' => $componentesSelecionados,
                        'options' => ['tag' => 'ul', 'style' => 'padding: 20px 10px 20px 10px !important; list-style-type:none', 'class' => 'connectedSortable alert alert-success'],
                        'itemOptions' => ['tag' => 'li', 'style' => 'width: 300px; margin-top: 5px; border: 1px solid; border-radius: 5px; text-align: center', 'class' => 'alert-info'],
                        'clientOptions' => ['cursor' => 'move', 'connectWith' => '.connectedSortable'],
                    ]);
                    ?>
                </td>
            </tr>
        </table>
    </div>

</div>
</br>
<?php
echo '<div class="form-group col-lg-12" style="width: 100%; margin: auto !important; text-align: center">' . Html::submitButton("Salvar", ["class" => "btn btn-primary",
        "onClick" => "{
    document.getElementById('ordemComponentes').value = '';
    var a = document.getElementById('olComponentes').children;
        var ordem = '';
    for(var i = 0; i < a.length; i++){
        console.log(a[i].attributes['value']);
        ordem += a[i].attributes['value'].value+';';
    }
    document.getElementById('ordemComponentes').value = ordem;
}"]) . '</div>';
?>
<?php
ActiveForm::end();
?>
