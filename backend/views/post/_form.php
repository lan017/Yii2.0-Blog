<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PostModel */
/* @var $form yii\widgets\ActiveForm */
$model->user_id = 0;
$model->user_name = 'zhangsan';
$model->is_valid = 1;
?>

<div class="post-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 3]) ?>

    <!--集成markdown-->
    <?= $form->field($model, 'content', ['labelOptions' => ['style' => 'background:#D8DCE3; width:100%;'], 'options' => ['style' => 'background:#fff;border:1px solid red']])->widget('ijackua\lepture\Markdowneditor') ?>

    <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
        'config'=>[
            //图片上传的一些配置，不写调用默认配置
            'domain_url' => 'http://admin.blog.com',
        ]
    ]) ?>

    <?= $form->field($model, 'cat_id')->dropDownList(['1' => 'java'], ['prompt' => '请选择父分类']) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_valid')->radioList(['0' => '暂不发布', '1' => '发布']) //droDownList(['1'=>'有效','0'=>'无效'])?>

    <?= $form->field($model, 'created_at')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '请选择时间'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'updated_at')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => '请选择时间'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ]
    ]); ?>

<!--    --><?//=$form->field($model,'tags')->widget('common\widgets\tags\TagWidget') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
