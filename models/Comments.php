<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $model_class
 * @property integer $model_pk
 * @property integer $author_id
 * @property string $created
 * @property string $content
 * @property integer $approved
 * @property integer $parent_id
 *
 * @property Comments $parent
 * @property Comments[] $comments
 * @property CommentsMeta[] $commentsMetas
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_class', 'model_pk', 'author_id', 'content'], 'required'],
            [['model_pk', 'author_id', 'approved', 'parent_id'], 'integer'],
            [['created'], 'safe'],
            [['content'], 'string'],
            [['model_class'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_class' => Yii::t('app', 'Model Class'),
            'model_pk' => Yii::t('app', 'Model Pk'),
            'author_id' => Yii::t('app', 'Author ID'),
            'created' => Yii::t('app', 'Created'),
            'content' => Yii::t('app', 'Content'),
            'approved' => Yii::t('app', 'Approved'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comments::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentsMetas()
    {
        return $this->hasMany(CommentsMeta::className(), ['comment_id' => 'id']);
    }
}
