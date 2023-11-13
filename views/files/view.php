<?php

use yii\helpers\Html;

$this->title = 'View File';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="image-view h-100">
    <div class="d-flex flex-wrap justify-content-start">
        <div class="card mb-1 col" style="height: 800px;">
            <div class="card-header">
                <?= Html::encode($model->FileName) ?>
            </div>
            <div class="card-body">
                <?php if (strpos($model->ContentType, 'application/vnd.openxmlformats-officedocument') !== false) { ?>
                    <?= Html::a('Download File', ['download', 'id' => $model->FileID], ['target' => '_blank']) ?>
                <?php } else { ?>
                    <iframe src="<?= Yii::$app->urlManager->createUrl(['files/display', 'id' => $model->FileID]) ?>" class="p-2 h-100 border-0" width="100%"></iframe>
                <?php } ?>
            </div>
        </div>
    </div>
</div>