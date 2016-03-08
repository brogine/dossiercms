<?php

namespace app\controllers\admin;

class MultimediaController extends \yii\web\Controller
{
    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpload()
    {
        return $this->render('upload');
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
