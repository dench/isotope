<?php

namespace app\controllers;

use app\components\AuthHandler;
use app\helpers\Timezone;
use app\models\LoginForm;
use app\models\SignupForm;
use dench\page\models\Page;
use rmrevin\yii\geoip\HostInfo;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
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
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you very much for registering. Your account has been successfully created.'));
                    return $this->redirect(Url::to(['/personal/default/profile']));
                }
            }
        } else {
            $model->country_id = (new HostInfo())->getCountryCode();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Displays Sign-in.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::to(['/personal/default/index']));
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionAjaxTimezone()
    {
        $out = [];

        if ($depdrop_parents = Yii::$app->request->post('depdrop_parents')) {
            $id = end($depdrop_parents);
            $list = Timezone::getList($id);
            foreach ($list as $k => $v) {
                $out[] = [
                    'id' => $k,
                    'name' => $v,
                ];
            }
        }

        $selected = reset($out);

        echo Json::encode(['output' => $out, 'selected' => @$selected['id']]);
        return;
    }
}
