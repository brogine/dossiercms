<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules()
    {
        return [
            [['files'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif, wav, mp3, flv, mp4, avi, doc, docx, xls, xlsx, pdf'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->files as $file) {

                $fileName = uniqid() . '.' . $file->extension;
                $fileLocation = current(explode('/', $file->type));
                $filePath = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $fileLocation . DIRECTORY_SEPARATOR;

                if (realpath($filePath) === false OR !is_dir(realpath($filePath)))
                	mkdir($filePath, 0777);

                if($file->saveAs($filePath . $fileName)) {
                	// Store it
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