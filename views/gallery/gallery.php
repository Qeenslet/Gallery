<?php
/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 27.10.17
 * Time: 18:07
 */
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 24.10.17
 * Time: 16:25
 */
$this->title = 'Моя галерея';
$this->params['breadcrumbs'][] = $this->title; ?>

<div class="modal fade" tabindex="-1" role="dialog" id="imageModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalImgTitle"></h4>
            </div>
            <div class="modal-body" id="modalImgBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data',
                                               'class' => 'box']]) ?>
<div class="box__input" style="padding: 15px">
<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'class' => 'box__file']) ?>
</div>
<div style="padding: 15px">
    <div class="box__uploading">Загрузка...&hellip;</div>
    <div class="box__success">Готово!</div>
    <div class="box__error">Ошибка! <span></span>.</div>
</div>
<?php ActiveForm::end() ?>
<div style="margin-top: 10px" id="myfiles">
    <?
        foreach ($images as $image)
        {
            $id = uniqid();
            echo '<div class="mosaicflow__item" id="' . $id . '">';
            echo '<div class="trashCan"><span onclick="controlImage.requestDelete(\'' . $image['filename'] . '\', \'' . $id . '\')" title="Удалить" class="glyphicon glyphicon-trash"></span></div>';
            echo '<img src="' . Url::to(['gallery/display', 'filename' => $image['thumbname']]) . '" alt="uploaded" onclick="controlImage.displayFullsize(this)" data-self="' . $image['birthname'] . '" data-parent="' . $image['filename'] . '" style="cursor: pointer" width="230px" height="140px">';
            echo '</div>';
        }
    ?>
</div>
