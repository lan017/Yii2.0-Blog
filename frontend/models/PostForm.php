<?php

namespace frontend\models;

use common\models\RelationPostTagsModel;
use Yii;
use yii\base\Model;
use common\models\PostsModel;
use yii\db\Exception;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class PostForm extends Model{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;
    public $_lastError = "";

    // 定义场景
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    /**
     * 定义事件
     * const EVENT_AFTER_CREATE="eventAfterCreate";创建之后的事件
     * const EVENT_AFTER_UPDATE="eventAfterUpdate"; 更新之后的事件
     */
    const EVENT_AFTER_CREATE = "eventAfterCreate";
    const EVENT_AFTER_UPDATE = "eventAfterUpdate";


    // scenarios : [sɪ'nɑ:ri:əʊz] , 场景设置
    public function scenarios(){
        $scenarios = [
            self::SCENARIOS_CREATE => ['title', 'content', 'label_img', 'cat_id', 'tags'],
            self::SCENARIOS_UPDATE => ['title', 'content', 'label_img', 'cat_id', 'tags']
        ];
        return array_merge(parent::scenarios(), $scenarios);
    }

    // 表单规则
    public function rules() {
        return [
            [['id', 'title', 'content', 'cat_id'], 'required'], // 定义好的表单路由规则，根据规则匹配输入项，这个完全可以用js定义好
            [['id','cat_id'], 'integer'],
            ['title','string','min'=>4,'max'=>50],
        ];
    }

    // 属性，from表单
    public function attributeLabels() {
        return[
            'id'=>Yii::t('common','id'),
            'title'=>Yii::t('common','title'),
            'content'=>Yii::t('common','content'),
            'label_img'=>Yii::t('common','label_img'),
            'tags'=>Yii::t('common','tags'),
            'cat_id'=>Yii::t('common','cat_id'),
        ];
    }

    public function create() {
        // 事务(涉及多个表，保证数据的完整性)
        $translation = Yii::$app->db->beginTransaction();

        try{
            $model = new PostsModel();
            $model->setAttributes($this->attributes);

            // 设置属性
            $model->summary = $this->_getSummary(); // 简介
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid = PostsModel::IS_VALID;
            $model->created_at = time();
            $model->updated_at = time();
            if (!$model->save()) {
                throw new \Exception('文章保存失败');
            } else {
                $this->id = $model->id;

                // 调用事件，类似TP的后置方法(添加事件，触发事件)
                $data =array_merge($this->getAttributes(), $model->getAttributes()); // 可合并可不合并，合并的话数据更完整
                $this->_eventAfterCreate($data); // 事件需要参数，绑定数据
            }

            $translation->commit();
            return true;
        }catch (\Exception $e){
           $translation->rollBack();
           $this->_lastError = $e->getMessage();
           return false;
        }
    }

    private function _getSummary($s = 0, $e = 90, $char = 'utf-8') {
        if (empty($this->content)) return null;
        return(mb_substr(str_replace('$nbsp;','',strip_tags($this->content)), $s,$e,$char));
    }

    /**
     * 创建完成后调用事件方法
     */
    public function _eventAfterCreate($data) {
        //添加事件
        $this->on(self::EVENT_AFTER_CREATE, [$this, '_eventAddTag'], $data);
//        $this->on(self::EVENT_AFTER_CREATE, [$this, '_event2'], $data); // 传入多个事件的时候，复制一个即可

        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    // 事件方法1，添加标签，添加一个表单模型
    public function _eventAddTag($event) {
        // 保存标签
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagIds = $tag->saveTags(); // 编辑/新增

        // 删除原先的关联关系,删除原来所有的标签，重新加
        RelationPostTagsModel::deleteAll([
            'post_id' => $event->data['id']
        ]);

        // 批量保存，标签不止一个
        if (!empty($tagIds)) {
            foreach ($tagIds as $k => $v) {
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id'] = $v;
            }

            // 批量插入
            $res = (new Query())->createCommand()
                ->batchInsert(RelationPostTagsModel::tableName(), ['post_id', 'tag_id'], $row)
                ->execute();

            if (!$res) {
                throw new Exception('文章关联关系保存失败！');
            }
        }
    }

    // 文章详情
    public function getViewById($id) {
        $res = PostsModel::find()->with('relate.tag', 'extend')->where(['id' => $id])->asArray()->one();
        if (!$res) {
            throw new NotFoundHttpException('文章不存在');
        }

        $res['tags'] = [];
        if (isset($res['relate']) && !empty($res['relate'])) {
            foreach ($res['relate'] as $k => $v) {
                $res['tags'][] = $v['tag']['tag_name'];
            }
        }
        unset($res['relate']);

        return $res;
    }

    // 获取post列表
    public static function getDealList($cond, $curPage = 1, $pageSize = 12, $orderBy = ['id' => SORT_DESC]) {
        $model = new PostsModel();

        $select = ['id', 'title', 'summary', 'label_img', 'user_id', 'user_name', 'cat_id', 'is_valid', 'created_at', 'updated_at'];
        $query = $model->find()->select($select)->where($cond)->with('relate.tag', 'extend')->orderBy($orderBy);
        $res = $model->getPages($query, $curPage, $pageSize);

        if ($res) {
            $res['data'] = self::_formatData($res['data']);
        }

        return $res;
    }

    // 处理tag
    private static function _formatData($dataList) {
        foreach ($dataList as &$data) {
            $data['tags'] = [];
            if (isset($data['relate']) && !empty($data['relate'])) {
                foreach($data['relate'] as $k => $v) {
                    $data['tags'][] = $v['tag']['tag_name'];
                }
            }
            unset($data['relate']);
        }

        return $dataList;
    }
}

