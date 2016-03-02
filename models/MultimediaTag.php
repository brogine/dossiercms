<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "multimedia_tag".
 *
 * @property integer $multimedia_id
 * @property string $tag_id
 * @property integer $order
 *
 * @property Multimedia $multimedia
 * @property Tags $tag
 */
class MultimediaTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'multimedia_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['multimedia_id', 'tag_id'], 'required'],
            [['multimedia_id', 'order'], 'integer'],
            [['tag_id'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'multimedia_id' => Yii::t('app', 'Multimedia ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
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
    public function getTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }
}
