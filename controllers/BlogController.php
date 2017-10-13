<?php

namespace app\controllers;

use dench\page\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class BlogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage('blog');

        $dataProvider = new ActiveDataProvider([
            'query' => $page->getChilds()->where(['enabled' => 1]),
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($slug)
    {
        $page = Page::viewPage($slug);
        if (!$page->enabled) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
            'page' => $page,
        ]);
    }

}
