<?php

use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'File Upload';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="image-upload">
    <div class="card border border-danger">
        <div class="card-header m-0 bg-danger">
            <h3 class="text-white"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'fileInput')->widget(FileInput::className(), [
                'name' => 'fileInput',
                'options' => [
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'initialPreview' => $model->FileData ?
                        [
                            'data:' . $model->ContentType . ';base64,' . base64_encode($model->FileData),
                        ] : [], // Only set initialPreview if there is a related record
                    'uploadUrl' => Url::to(['upload']),
                    'maxFileCount' => 10,
                    'showCaption' => false,
                    'showRemove' => true,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="fas fa-file"></i> ',
                    'browseLabel' =>  'Select File',
                    'showUpload' => false,
                    'enableResumableUpload' => true,
                    'initialPreviewAsData' => true,
                    'showCancel' => true,
                    // 'theme' => 'fa5',
                    'initialPreviewConfig' => $model->FileData ?
                        [
                            [
                                'type' => $model->ContentType,
                                'caption' => $model->FileName,
                                'size' => $model->FileSize,
                                'url' => Url::to(['delete', 'id' => $model->FileID]),
                                'key' => $model->FileID,
                                'downloadUrl' => Url::to(['download', 'id' => $model->FileID]),
                            ],
                        ] : [], // Only set initialPreviewConfig if there is a related record
                    'overwriteInitial' => false, //
                ],
            ])->label('File Upload') ?>

        </div>
        <div class="card-footer">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-success btn-sm']) ?>

        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>