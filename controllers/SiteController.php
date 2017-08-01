<?php

namespace app\controllers;

use dench\page\models\Page;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     */
    public function actionIndex()
    {
        Page::viewPage('index');

        $this->view->params['class_page'] = 'home';

        return $this->render('index');
    }

    /**
     * Displays page.
     */
    public function actionPage($slug = null)
    {
        Page::viewPage($slug);

        return $this->render('page');
    }

    /**
     * Displays contact page.
     */
    public function actionContacts()
    {
        Page::viewPage(12);

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays Sign-up.
     */
    public function actionSignup()
    {
        return $this->render('signup');
    }

    /**
     * Displays Sign-in.
     */
    public function actionSignin()
    {
        return $this->render('signin');
    }
}
