<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建分类', ['create'], ['class' => 'btn btn-success glyphicon glyphicon-plus']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider, // 数据提供者（数组）
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'], // ID序号

//            'id',
//            'pid',
//            'catname',

//        'id:text:ID',
//'pid:text:父分类',
//'catname:text:名称',
//'create_at:datetime:发布时间',

            ['label' => 'ID', 'attribute' => 'id'],
            ['label' => '名称', 'attribute' => 'catname'],
            ['label' => '别名', 'attribute' => 'label'],
            [
                'label' => '状态',
                'attribute' => 'hidden',
                'format' => 'raw',
                'headerOptions' => ['width' => '60'],
                'value' => function($model) {
                    return $model['hidden'] == 1 ? '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
                },
//                'contentOptions' => ['style' => 'text-align:center']
            ],
            [
                'label' => '发布时间',
                'attribute' => 'create_at',
                'format' => 'datetime',
                'headerOptions' => ['class' => 'red'], // 添加CSS类
                'contentOptions' => ['style' => 'color:blue;'] ,// 直接加行内样式
                'value' => function($model) {
                    return date("Y-m-d H:i:s", $model['create_at']);
                },
                'visible' => true, // 可以用权限控制显示或者隐藏，
            ],
//            'description',

            //'listorder',

//            ['class' => 'yii\grid\ActionColumn'], // 默认操作按钮
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{cateAdd} {create} {update} {delete} {view}', // 查看是view
                'urlCreator' => function($action, $model, $key, $index) {
                    switch ($action) {
                        case 'update' :
                            return '/category/update.html?id=' . $model['id'];
                            break;
                        case 'delete':
                            return '/category/delete.html?id=' . $model['id'];
                            break;
                        case 'view':
                            return '/category/view.html?id=' . $model['id'];
                            break;
                    }
                },
                'buttons' => [
//                    'create' => function($url, $model, $key) {

//                        return Html::a('<span class="glyphicon glyphicon-plus btn btn-warning btn-sm"></span>', $url, ['title' => '添加']);
//                    },
//                'update' => function($url, $model) {
//                    return Html::a('更新分类' , '/category/update?id=' . $model['id'], ['title' => '更改']);
//                },
                    'cateAdd' => function($url, $model, $key) {
                        $url = '/category/create.html?pid=' . $model['id'];
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['title' => '添加子分类']);
                    },
                    'update-status' => function($url, $model, $key) {
                        return Html::a('更新状态', "javascript:;", ["onclick" => "alert(111)"]);
//                        return Html::a('更新状态', "javascript:;", ["onclick" => "update_status($this, " . $model->id . ")"]);
                    }
                ],
                'headerOptions' => ['width' => '150']
            ],
            [
                'attribute' => '更多操作', // 自定义按钮,也可以用label
                'format' => 'raw', // 标签样式
                'value' => function($model) {
                    $url = 'http://baidu.com?pid=' . $model['pid'];
                    return Html::a('权限控制', $url, ['title' => '审核']);
                }
            ],
        ], // 显示的字段
        'emptyText' => '当前没有内容', // 无结果提示
        'emptyTextOptions' => ['style' => 'color:red;font-weight:bold'], // 无结构样式
        'rowOptions' => function($model, $key, $index) {
            if ($index%2 === 0) {
                return ['style' => 'background:#CCC']; // 行配置，隔行换色, $model是被渲染的对象
            }
        },
        'footerRowOptions' => ['style' => 'font-size:10px'], // 控制底的高度和样式
//        'afterRow' => function ($model, $key, $index, $grid) {
//            if (($index+1)%2 != 0) {
//                return "<tr><td colspan='4'>我是基数行</td></tr>"; // 后置函数
//            }
//        },
        'showFooter' => true, // 显示底部（每一列都有一个header,content,footer）
        'layout' => "{items}\n{pager}", // 去掉summary
        'caption' => '分类列表', // 列表的标题
//        'emptyCell' => '空的', // 空单元格,
    ]); ?>
</div>
