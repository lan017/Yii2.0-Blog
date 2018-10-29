<?php

namespace frontend\controllers;

/*
基础控制器
 */
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }
        return true;
    }

}