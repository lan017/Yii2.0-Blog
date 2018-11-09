<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '内容管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-model-index">


    <p>
        <?= Html::a('发布文章', ['create'], ['class' => 'btn btn-success glyphicon glyphicon-plus']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            ['label' => 'ID', 'attribute' => 'id', 'headerOptions' => ['width' => 80]],
            [
                'label' => '标题',
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model) {
                    return '<a href="http://frontend.hyii2.com/'.Url::to(['post/view','id'=>$model->id]).'">'.$model->title.'</a>';
                }
            ],

            ['label' => '描述', 'attribute' => 'summary'],
            //'content:ntext',
            //'label_img',
             ['label' => '所属分类', 'attribute' => 'cat.cat_name'],
            // 'user_id',
//             'user_name',
            [
                'label' => '是否发布',
                'attribute' => 'is_valid',
                'value' => function($model) {
                    return $model->is_valid == 1 ? '有效' : '无效';
                },
                'filter'=>['1'=>'有效','0'=>'无效']],
            [
                'label' => '发布时间',
                'attribute' => 'created_at',
                'format' => 'datetime'
            ],
            [
                'label' => '更新时间',
                'attribute' => 'updated_at',
                'format' => 'datetime'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'layout' => "{items}\n{pager}",
        'showFooter' => true, // 显示底部（每一列都有一个header,content,footer）
        'footerRowOptions' => ['style' => 'font-size:10px'], // 控制底的高度和样式
        'caption' => '文章列表', // 列表的标题
    ]); ?>

</div>
