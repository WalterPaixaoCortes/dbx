<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;

$this->title = 'Componentes';
?>
<div class="" style="text-align: center !important; margin: auto; margin-top: 10vh !important; max-width: 600px">
    <?php
    echo Html::a('<button type="button" class="btn btn-primary">Componentes de Coleta</button>', ['componente/componentes-coleta'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br></br>";
    echo Html::a('<button type="button" class="btn btn-primary">Componentes de Refinamento</button>', ['componente/componentes-refinamento'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br></br>";
    echo Html::a('<button type="button" class="btn btn-primary">Componentes Visuais</button>', ['componente/componentes-visuais'], ['options' => ['class' => 'btn btn-primary btn-block btn']]) . "</br></br>";
    ?>

</div>
