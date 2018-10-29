<?php

namespace frontend\widgets\ScrollBanner;

use yii\bootstrap\Widget;

class ScrollBannerWidget extends Widget{
    public $items = [];
    public $limit = 6;

    public function init() {
        if (empty($this->items)) {
            $this->items = [
                [
                    'label' => '幻灯片1',
                    'url' => ['post/index'],
                    'img' => '/statics/images/banner/b_0.jpg',
                    'description' => '',
                    'active' => 'active'
                ],
                [
                    'label' => '幻灯片1',
                    'url' => ['post/index'],
                    'img' => '/statics/images/banner/b_1.jpg',
                    'description' => '',
                ],
                [
                    'label' => '幻灯片1',
                    'url' => ['post/index'],
                    'img' => '/statics/images/banner/b_2.jpg',
                    'description' => '',
                ]
            ];
        }
    }

    public function run() {
        $data['items'] = $this->items;

        return $this->render('index', ['data' => $data]);
    }
}