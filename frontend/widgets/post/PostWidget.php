<?php

namespace frontend\widgets\post;

use Yii;
use common\models\PostsModel;
use frontend\models\PostForm;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

//[ˈwɪdʒɪt] , Summary
class PostWidget extends widget
{
    public $seoTitle = '';
    public $limit = 6;
    public $hasPages = true;
    public $more = true;

    public function run() {

        $curPage = Yii::$app->request->get('page', 1);

        $cond = ['=', 'is_valid', PostsModel::IS_VALID];
        $res = PostForm::getDealList($cond, $curPage, $this->limit);

        $result['title'] = $this->seoTitle ? : '最新列表';
        $result['more'] = Url::to(['post/index']);
        $result['body'] = $res['data'] ? : [];

        if ($this->hasPages) {
            $pages = new Pagination(['totalCount' => $res['count'] , 'pageSize' => $this->limit]);
            $result['page'] = $pages;
        }

        return $this->render('index', ['data' => $result]); // 一定要记得return 出来！这里是个坑，浪费了不少时间；样式的问题记得要清理缓存
    }
}