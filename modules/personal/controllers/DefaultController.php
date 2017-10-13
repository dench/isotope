<?php

namespace app\modules\personal\controllers;

use app\modules\personal\models\MainForm;
use app\modules\personal\models\ProfileForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `personal` module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAccount()
    {
        $model = new MainForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Information has been saved successfully'));
                return $this->redirect(Url::to(['/personal/default/account']));
            }
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $model = new ProfileForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Information has been saved successfully'));
                return $this->redirect(Url::to(['/personal/default/profile']));
            }
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

}
