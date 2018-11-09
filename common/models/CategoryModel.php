<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $pid 父级id
 * @property string $catname
 * @property string $label 别名
 * @property string $description
 * @property int $hidden 是否隐藏
 * @property int $listorder
 */
class CategoryModel extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * 这部分也可以用js控制，这个相当于一个表单组件
     */
    public function rules()
    {
        return [
            [['pid', 'hidden', 'listorder'], 'integer'],
            [['catname', 'label'], 'required'],
            [['catname', 'label'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 300],
            [['catname'], 'unique'],
        ];
    }

    /**
     * 表头的属性
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父分类',
            'catname' => '名称',
            'label' => '别名',
            'description' => '描述',
            'hidden' => '是否隐藏',
            'listorder' => '排序',
            'create_at' => '发布时间',
        ];
    }

    // 类似从java api取数据
    public static function getAllCategories()
    {
        $categories = self::find()->select(['id', 'pid', 'catname', 'create_at', 'hidden', 'label'])->asArray()->all();

        return $categories;
    }
}
