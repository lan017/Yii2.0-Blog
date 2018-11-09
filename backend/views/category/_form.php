<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryModel */
/* @var $form yii\widgets\ActiveForm */

if (Yii::$app->request->get('pid')) {
    $model->pid = Yii::$app->request->get('pid');
}

$model->hidden = 0;
$model->listorder = 0;
$model->create_at = date('Y:m:d H:m:i');
array_unshift($categories, "顶级分类");

?>

<div class="category-model-form">

    <!--设置统计样式-->
    <?php $form = ActiveForm::begin([
            'fieldConfig' => [
//                'template' => "{label}\n<div class=\"col-sm-8\">{input}</div>\n{error}",
            ]
    ]); ?>

    <?=
        $form->field($model, 'pid')->dropDownList(
            $categories,
            ['prompt' => '请选择父分类']
        )
    ?>

    <?= $form->field($model, 'catname')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->input('text', ['style' => 'height:200px; width:60%']) ?>

    <?= $form->field($model, 'create_at')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '请选择时间'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ]
    ]); ?>


    <?=
        $form->field($model, 'hidden')->radioList([
            1 => '是',
            0 => '否'
        ])
    ?>

    <?= $form->field($model, 'listorder')->input('text', ['style' => 'width:10%']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>





    <?php ActiveForm::end(); ?>

</div>
