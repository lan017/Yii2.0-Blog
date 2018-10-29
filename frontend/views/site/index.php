<?php

use frontend\widgets\scrollBanner\ScrollBannerWidget;
use frontend\widgets\post\PostWidget;
use frontend\widgets\chat\ChatWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\tag\TagWidget;
$this->title = '博客-首页';
?>

<div class="row">
    <div class="col-lg-9">
        <!--首页轮播 -->
        <?= ScrollBannerWidget::widget() ?>

        <!--文章列表 -->
        <?= PostWidget::widget(['limit' => 5]) ?>
    </div>


    <div class="col-lg-3">
        <!--留言板 -->
        <?= ChatWidget::widget() ?>

        <!--热门浏览 -->
        <?= HotWidget::widget() ?>

        <!--标签云 -->
        <?= TagWidget::widget() ?>
    </div>
</div>