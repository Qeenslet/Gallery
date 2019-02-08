<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Поздравляем!</h1>

        <p class="lead">Gallery открыта!</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['gallery/mygallery']) ?>">Начать</a></p>
    </div>
</div>
