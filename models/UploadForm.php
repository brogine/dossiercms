<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif, wav, mp3, flv, mp4, avi, doc, docx, xls, xlsx, pdf', 'maxFiles' => 0],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->files as $file) {

                $fileName = uniqid() . '.' . $file->extension;
                $fileLocation = current(explode('/', $file->type));
                $filePath = Yii::getAlias(Yii::$app->params['media.basePath']) . $fileLocation . DIRECTORY_SEPARATOR;

                FileHelper::createDirectory($filePath);

                if($file->saveAs($filePath . $fileName)) {
                	$nMultimedia = new Multimedia();
                	$nMultimedia->mime = $file->type;
                	$nMultimedia->location = $fileLocation . '/' . $fileName;
                	$nMultimedia->description = $file->name;
                	$nMultimedia->save();
                }

            }
            return true;
        } else {
            return false;
        }
    }
}