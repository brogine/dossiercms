<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Posts */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Posts'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'headline',
            [
                'attribute' => 'author_id',
                'value' => 'author.username',
            ],
            [
                'attribute' => 'publish',
                'format' => ['date', \Yii::$app->params['dateDisplay']]
            ],
            [
                'attribute' => 'status',
                'value' => 'statusDesc',
                'filter' => $searchModel->status(),
            ],
            [
                'attribute' => 'category_id',
                'value' => 'category.description',
            ],
            
            // 'version',
            // 'tags:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
