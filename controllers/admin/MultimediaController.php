<?php

namespace app\controllers\admin;

use app\models\UploadForm;
use Yii;
use yii\web\UploadedFile;

class MultimediaController extends BaseAdminController
{
    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        $model = new UploadForm();
        return $this->render('index', ['model' => $model]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->files = UploadedFile::getInstances($model, 'files');

            $statusCode = 0;
            $errors = null;

            if ($model->upload())
                $statusCode = 200;
            else {
                $errors = $model->errors;
                $statusCode = 400;
            }

            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->statusCode = $statusCode;
            return ['success' => ($statusCode == 200 ? true : false), 'errors' => $errors];
        }

        return $this->redirect(['index']);
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
