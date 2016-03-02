<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_multimedia".
 *
 * @property integer $post_id
 * @property integer $multimedia_id
 * @property string $description
 * @property string $mime
 * @property integer $order
 *
 * @property Multimedia $multimedia
 * @property Posts $post
 */
class PostMultimedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_multimedia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'multimedia_id', 'mime'], 'required'],
            [['post_id', 'multimedia_id', 'order'], 'integer'],
            [['description'], 'string'],
            [['mime'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('app', 'Post ID'),
            'multimedia_id' => Yii::t('app', 'Multimedia ID'),
            'description' => Yii::t('app', 'Description'),
            'mime' => Yii::t('app', 'Mime'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMultimedia()
    {
        return $this->hasOne(Multimedia::className(), ['id' => 'multimedia_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }
}
