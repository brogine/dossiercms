<?php

namespace app\controllers\admin;

use app\models\UploadForm;
use app\models\Multimedia;
use Yii;
use yii\web\UploadedFile;
use yii\web\View;

class MultimediaController extends BaseAdminController
{
    public function actionDelete()
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Multimedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Multimedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Multimedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionIndex()
    {
        $model = new UploadForm();

        $multimedia = Multimedia::find()->all();
        
        return $this->render('index', [            
            'model' => $model, 
            'multimedia' => $multimedia,
        ]);
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
            return ['success' => ($errors == 200 ? true : false), 'error' => $errors];
        }

        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post()))
            $model->save();

        return $this->render('view', [
            'model' => $model,
        ]);
    }

}
