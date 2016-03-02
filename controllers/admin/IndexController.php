<?php

namespace app\controllers\admin;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class IndexController extends BaseAdminController
{

	public function actionIndex()
    {
        return $this->render('index');
    }

}