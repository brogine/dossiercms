<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Posts as PostsModel;

/**
 * Posts represents the model behind the search form about `app\models\Posts`.
 */
class Posts extends PostsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['headline', 'author_id', 'category_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostsModel::find();

        $query->joinWith(['category', 'author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'publish' => $this->publish,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'headline', $this->headline])
            ->andFilterWhere(['like', Categories::tableName() . '.description', $this->category_id])
            ->andFilterWhere(['like', User::tableName() . '.username', $this->author_id])
            /*->andFilterWhere(['like', 'user.username', $this->author_id])*/;

        return $dataProvider;
    }
}
