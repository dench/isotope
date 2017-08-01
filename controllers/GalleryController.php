<?php

namespace app\controllers;

use dench\page\models\Page;

class GalleryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        Page::viewPage('gallery');

        return $this->render('index');
    }

}
