<?php
namespace common\models\base;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    public function getPages($query, $curPage = 1, $pageSize = 10, $search = null) {
        // 搜索过滤
        if (isset($search)) {
            $query = $query->addFilerWhere($search);
        }

        $data['count'] = $query->count();
        if (empty($data['count'])) {
            return ['count' => 0, 'curPage' => $curPage, 'end' => 0, 'data' => []];
        }

        // 拼接页码请求参数
        $curPage = $curPage > ceil($data['count'] / $pageSize) ? ceil($data['count'] / $pageSize) : $curPage;
        $data['curPage'] = $curPage;
        $data['pageSize'] = $pageSize;
        $data['start'] = ceil($curPage - 1) * $pageSize + 1; // 起始页
        $data['end'] = $data['start'] + $pageSize;

        $data['data'] = $query->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            ->asArray()
            ->all();

        return $data;
    }
}