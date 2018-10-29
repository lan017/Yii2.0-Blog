<?php
use frontend\widgets\post\PostWidget;
use yii\helpers\Url;
?>
<div class=="col-lg-9">
    <div class="col-lg-9">
        <?= PostWidget::widget(['limit' => 3]); ?>
    </div>
    <div class="col-lg-3">
        <a class="btn btn-success btn-block btn-post" href="<?=Url::to(['post/create'])?>">创建文章</a>
        <a class="btn btn-info btn-block btn-post" href="<?Url::to(['post/update','id'=>$data['id']])?>">编辑文章</a>
    </div>
</div>