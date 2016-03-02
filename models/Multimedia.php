<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "multimedia".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $mime
 * @property string $location
 * @property string $description
 * @property string $credits
 * @property integer $row
 * @property integer $column
 * @property string $tags
 *
 * @property Categories $category
 * @property MultimediaTag[] $multimediaTags
 * @property Tags[] $tags0
 * @property PostMultimedia[] $postMultimedia
 * @property Posts[] $posts
 */
class Multimedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'multimedia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'mime'], 'required'],
            [['category_id', 'row', 'column'], 'integer'],
            [['tags'], 'string'],
            [['mime'], 'string', 'max' => 50],
            [['location', 'description', 'credits'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'mime' => Yii::t('app', 'Mime'),
            'location' => Yii::t('app', 'Location'),
            'description' => Yii::t('app', 'Description'),
            'credits' => Yii::t('app', 'Credits'),
            'row' => Yii::t('app', 'Row'),
            'column' => Yii::t('app', 'Column'),
            'tags' => Yii::t('app', 'Tags'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMultimediaTags()
    {
        return $this->hasMany(MultimediaTag::className(), ['multimedia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags0()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('multimedia_tag', ['multimedia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMultimedia()
    {
        return $this->hasMany(PostMultimedia::className(), ['multimedia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::className(), ['id' => 'post_id'])->viaTable('post_multimedia', ['multimedia_id' => 'id']);
    }
}
