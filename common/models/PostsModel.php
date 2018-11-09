<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id 自增ID
 * @property string $title 标题
 * @property string $summary 摘要
 * @property string $content 内容
 * @property string $label_img 标签图
 * @property int $cat_id 分类id
 * @property int $user_id 用户id
 * @property string $user_name 用户名
 * @property int $is_valid 是否有效：0-未发布 1-已发布
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class PostsModel extends BaseModel
{
    const IS_VALID = 1; // 已发布
    const NO_VALID = 0; // 未发布
    /**
     * {@inheritdoc} , form模型没有映射表
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255],
        ];
    }

    public function getRelate() {
        return $this->hasMany(RelationPostTagsModel::className(), ['post_id' => 'id']);
    }

    public function getExtend() {
        return $this->hasOne(PostExtendsModel::className(), ['post_id' => 'id']);
    }

    public function getCat() {
        return $this->hasOne(CatsModel::className(), ['id' => 'cat_id']);
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'summary' => '描述',
            'content' => '内容',
            'label_img' => '缩略图',
            'cat_id' => '分类',
            'user_id' => '发布者',
            'user_name' => 'User Name',
            'is_valid' => '是否发布',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function upCounter() {

    }
}
