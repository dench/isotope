<?php

namespace app\controllers;

use dench\page\models\Page;

class BlogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        Page::viewPage('blog');

        return $this->render('index');
    }

}
