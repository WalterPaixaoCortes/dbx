<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Proteina';
?>
<?php
if(Yii::$app->getSession()->getFlash('msg') != null){
    echo '<p style="color: #FF0000; width: 100%; text-align: center">'.Yii::$app->getSession()->getFlash('msg').'</p>';
}
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'proteina-form',
        'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div><div class=\"col-lg-9\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'nome')->textInput(); ?>
    <?= $form->field($model, 'dados')->textarea(["rows"=>10]); ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(""); ?>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-5">
            <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'enviar-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
