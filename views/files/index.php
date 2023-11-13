<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\daterange\DateRangePicker;

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => 's/n'
        ],
        ['attribute' => 'FileName', 'filterInputOptions' => ['class' => 'form-control', 'placeholder' => 'Filter by file name ...']],
        ['attribute' => 'FileType', 'filterInputOptions' => ['class' => 'form-control', 'placeholder' => 'Filter by file type ...']],
        ['attribute' => 'ContentType', 'filterInputOptions' => ['class' => 'form-control', 'placeholder' => 'Filter by content type ...']],
        [
            'attribute' => 'CreatedAt',
            'filter' => DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'CreatedAt',
                'convertFormat' => true,
                'options' => ['placeholder' => 'Filter by date created ...', 'class' => 'form-control'],
                'pluginOptions' => [
                    'timePicker' => true,
                    'timePickerIncrement' => 15,
                    'locale' => [
                        'format' => 'Y-m-d H:i:s',
                    ],
                ],
            ]),
            'format' => 'datetime',
        ],
        [
            'attribute' => 'FileSize',
            'value' => function ($model) {
                return number_format($model->FileSize) . ' kbs';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Actions',
            'template' => '{view} {update} {delete} {download}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-eye"></i>', ['view', 'id' => $model->FileID], ['class' => 'btn btn-sm btn-outline-primary border-0']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-pen"></i>', ['update', 'id' => $model->FileID], ['class' => 'btn btn-sm btn-outline-warning border-0']);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->FileID], ['class' => 'btn btn-sm btn-outline-danger border-0']);
                },
                'download' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-download"></i>', ['download', 'id' => $model->FileID], ['class' => 'btn btn-sm btn-outline-success border-0', 'target' => '_blank']);
                },
            ]
        ]
    ],
    'condensed' => true,
    'persistResize' => true,
    'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
    'panel' => [
        'heading' => '<h3 class="panel-title"><i class="fas fa-file"></i>' . $this->title . '</h3>',
        'type' => 'danger',
        'before' => Html::a('<i class="fas fa-upload"></i> UPLOAD FILE', ['upload'], ['class' => 'btn btn-sm btn-primary']),
        'after' => Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-primary btn-sm']),
    ],

]) ?>