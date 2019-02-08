<?php
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 24.10.17
 * Time: 16:25
 */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <h3>GGGGGGG</h3>
        <?php echo Html::img(Url::to(['gallery/display', 'filename' => 'test2.png']), ['alt' => 'Наш логотип']);
            //echo Url::to(['gallery/display', 'filename' => 'test2.png']);
        ?>

    </div>
</div>
