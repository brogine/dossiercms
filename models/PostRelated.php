<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post_related".
 *
 * @property integer $post_id
 * @property integer $post_related
 * @property integer $order
 *
 * @property Posts $post
 * @property Posts $postRelated
 */
class PostRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_related';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'post_related'], 'required'],
            [['post_id', 'post_related', 'order'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => Yii::t('app', 'Post ID'),
            'post_related' => Yii::t('app', 'Post Related'),
            'order' => Yii::t('app', 'Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostRelated()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_related']);
    }
}
