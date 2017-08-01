<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SitemapController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        $urls = [];

        $urls[] = [
            'loc' => Url::home('https'),
        ];

        return $this->renderPartial('index', [
            'urls' => $urls,
        ]);
    }

}