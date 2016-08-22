<?php

/* @var $this yii\web\View */

$this->title = 'DBX';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>
    </div>

    <div class="body-content">
        <?php var_dump(Yii::$app->user->isGuest); ?>
    </div>
</div>
