<?php

namespace backend\controllers;

use Yii;
use common\models\CategoryModel;
use common\models\CategorySearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for CategoryModel model.
 */
class CategoryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CategoryModel models.
     * @return mixed
     */
    public function actionIndex()
    {

        $categories = self::getTree();

        $model = new CategoryModel();

        $searchModel = new CategorySearch();

        $data = new ArrayDataProvider(
             [
                'allModels' => $categories,
                'pagination' => [
                    'pageSize' => 20,
                ]
            ]
        );

        return $this->render('index', ['dataProvider' => $data, 'model' => $model, 'searchModel' => $searchModel]);
//        $searchModel = new CategorySearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
    }

    public static function getTree() {
        $categoryModel = new CategoryModel();
        $res = $categoryModel->getAllCategories();
        if ($res) {
            $res = self::_genderateTree($res, 0, 0, '┅━━');
        }
        return $res;
    }

    /**
     * 递归实现无限级分类
     *
     * @param $data
     * @param int $pid
     * @param int $level 分类级别
     * @return array
     */
//    private static function _genderateTree($data, $pid = 0, $level = 0, $html = '--') {
//        $tree = []; // 避免递归调用时，多次声明导致数组被覆盖
//
//        if ($data && is_array($data)) {
//            foreach ($data as $k => $v) {
//                if ($v['pid'] == $pid) {
//                    $tree[] = [
//                        'id' => $v['id'],
//                        'pid' => $v['pid'],
//                        'catname' => str_repeat($html, $level) . $v['catname'], // $level来控制缩进
//                        'create_at' => $v['create_at'],
//                        'children' => self::_genderateTree($data, $v['id'], $level+1, $html)
//                    ];
//                    unset($data[$k]); // 释放内存，减少后续递归消耗
//                }
//            }
//        }
//
//        return $tree;
//    }
    public static function _genderateTree($data, $pid = 0, $level = 0, $html = '--') {
        static $tree = []; //定义一个静态数组

        if ($data && is_array($data)) {
            foreach ($data as $k => $v) {
                if($v['pid'] == $pid){
                    $v['catname'] = str_repeat($html, $level) . ' ' . $v['catname']; // $level来控制缩进
                    $tree[] = $v;
                    self::_genderateTree($data, $v['id'],$level+1, $html);
                }
                unset($data[$k]); // 释放内存，减少后续递归消耗
            }
        }

        return $tree;
    }

    /**
     * Displays a single CategoryModel model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CategoryModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]); // 编辑和新增是一个控制器
        }

        $pid = Yii::$app->request->get('pid'); // 获取父分类id

        $categories = self::getTree();

        foreach ($categories as $cateInfo) {
            $categoryTree[$cateInfo['id']] = $cateInfo['catname'];
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categoryTree
        ]);
    }

    /**
     * Updates an existing CategoryModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (empty($id)) {
            $id = Yii::$app->request->get('id');
        }


        $model = $this->findModel($id);

        // 更新和保存
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $categories = self::getTree();

        $categoryTree = [];
        foreach ($categories as $cateInfo) {
            $categoryTree[$cateInfo['id']] = $cateInfo['catname'];
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categoryTree,
        ]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CategoryModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
