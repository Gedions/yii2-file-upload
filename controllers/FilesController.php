<?php

namespace app\controllers;

use app\models\Files;
use app\models\FilesSearch;
use app\models\Edocs;
use Yii;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;

class FilesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new FilesSearch();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
        ]);
    }

    public function actionUpload()
    {
        $model = new Files();

        if (Yii::$app->request->isPost) {
            $model->fileInput = UploadedFile::getInstance($model, 'fileInput');
            // $edocs = new Edocs();
            // print_r('<pre>');
            // print_r($model->fileInput) . exit();

            // $response = json_decode($edocs->authenticate(
            //     'jgedions@gmail.com',
            // ));
            // if ($response->status == 1) {
            //     $params = [
            //         'author' => 'Quintine',
            //         'title' => 'Test Document',
            //         'letter_date' => date('Y-m-d H:i:s'),
            //         'received_date' => date('Y-m-d H:i:s'),
            //         'file' => base64_encode(file_get_contents($model->fileInput->tempName))
            //     ];
            //     $res = $edocs->postRecord($params);
            //     // $res = json_decode($edocs->getRecord(10));

            // }

            $upload = $model->upload();
            if ($upload) {
                return $this->redirect(['view', 'id' => $upload]);
            } else
                return $this->render('upload', ['model' => $model]);
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionView($id)
    {
        $model = Files::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Files::findOne($id);

        if (Yii::$app->request->isPost) {
            $model->fileInput = UploadedFile::getInstance($model, 'fileInput');
            if ($model->upload()) {
                return $this->redirect(['view', 'id' => $model->ID]);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        Files::findOne($id)->delete();
        // return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionDownload($id)
    {
        $model = Files::findOne($id);

        if ($model !== null) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('content-type', $model->ContentType);
            Yii::$app->response->headers->add('content-disposition', "attachment; filename={$model->FileName}");

            return $model->FileData;
        } else {
            throw new NotFoundHttpException('File not found.');
        }
    }

    public function actionDisplay($id)
    {
        $model = Files::findOne($id);

        if ($model !== null) {
            // Set the appropriate content type for the response
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('content-type', $model->ContentType);

            // Check if the content type indicates an office document
            $isOfficeDoc = strpos($model->ContentType, 'application/vnd.openxmlformats-officedocument') !== false;

            if ($isOfficeDoc) {
                // If it's an office document, prompt the user to open it in the relevant app
                Yii::$app->response->headers->add('content-disposition', "attachment; filename={$model->FileName}");
            } else {
                // For other file types, allow the browser to handle them and display in the iframe
                Yii::$app->response->headers->add('content-disposition', "inline; filename={$model->FileName}");
            }

            // Serve the file content
            return $model->FileData;
        } else {
            throw new NotFoundHttpException('File not found.');
        }
    }
}
