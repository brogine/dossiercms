<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $headline
 * @property string $kicker
 * @property string $billboard
 * @property string $content
 * @property integer $author_id
 * @property string $created
 * @property string $publish
 * @property integer $status
 * @property integer $comment_status
 * @property integer $parent
 * @property integer $category_id
 * @property integer $version
 * @property string $tags
 *
 * @property PostMeta[] $postMetas
 * @property PostMultimedia[] $postMultimedia
 * @property Multimedia[] $multimedia
 * @property PostRelated[] $postRelateds
 * @property PostRelated[] $postRelateds0
 * @property PostTag[] $postTags
 * @property Tags[] $tags0
 * @property Categories $category
 * @property Posts $parent
 * @property Posts[] $children
 * @property User $author
 */
class Posts extends \yii\db\ActiveRecord
{
    const STATUS_PRIVATE = 0;
    const STATUS_PENDING = 1;
    const STATUS_DRAFT = 2;
    const STATUS_PUBLISH = 3;

    private $status = null;

    public function status()
    {
        if($this->status == null)
        {
            $this->status = [
                1 => 'Private',
                2 => 'Pending',
                3 => 'Draft',
                4 => 'Publish'
            ];
        }

        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['headline', 'kicker', 'content', 'author_id', 'status', 'comment_status', 'category_id'], 'required'],
            [['billboard', 'content', 'tags'], 'string'],
            [['author_id', 'status', 'comment_status', 'parent', 'category_id', 'version'], 'integer'],
            [['created', 'publish'], 'date', 'format' => 'yyyy-M-d'],
            [['headline'], 'string', 'max' => 255],
            [['kicker'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'headline' => Yii::t('app', 'Headline'),
            'kicker' => Yii::t('app', 'Kicker'),
            'billboard' => Yii::t('app', 'Billboard'),
            'content' => Yii::t('app', 'Content'),
            'author_id' => Yii::t('app', 'Author'),
            'created' => Yii::t('app', 'Created'),
            'publish' => Yii::t('app', 'Publish'),
            'status' => Yii::t('app', 'Status'),
            'comment_status' => Yii::t('app', 'Comment Status'),
            'parent' => Yii::t('app', 'Parent'),
            'category_id' => Yii::t('app', 'Category'),
            'version' => Yii::t('app', 'Version'),
            'tags' => Yii::t('app', 'Tags'),
        ];
    }

    public function beforeValidate()
    {
        if($this->isNewRecord) $this->author_id = Yii::$app->user->id;
        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMetas()
    {
        return $this->hasMany(PostMeta::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostMultimedia()
    {
        return $this->hasMany(PostMultimedia::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMultimedia()
    {
        return $this->hasMany(Multimedia::className(), ['id' => 'multimedia_id'])->viaTable('post_multimedia', ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostRelateds()
    {
        return $this->hasMany(Posts::className(), ['post_id' => 'id'])->viaTable('post_related', ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags0()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('post_tag', ['post_id' => 'id']);
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
    public function getParent()
    {
        return $this->hasOne(Posts::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Posts::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}
