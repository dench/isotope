<?php

use app\helpers\Timezone;
use app\models\Country;
use kartik\depdrop\DepDrop;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'Edit account');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account'), 'url' => ['/personal/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <h1 class="title"><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <?= Yii::t('app', 'Password') ?>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'password_new')->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    <?= $form->field($model, 'password_current')->passwordInput() ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <?= Yii::t('app', 'E-mail') ?>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'email_news')->checkbox() ?>
                    <?= $form->field($model, 'email_notice')->checkbox() ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <?= Yii::t('app', 'Timezone') ?>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'country_id')->dropDownList(Country::getList(), ['id'=>'country-id']) ?>
                    <?= $form->field($model, 'timezone')->widget(DepDrop::classname(), [
                        'data' => Timezone::getList($model->country_id),
                        'options' => ['id'=>'ajax-timezone'],
                        'pluginOptions'=>[
                            'depends'=>['country-id'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['/site/ajax-timezone']),
                        ]
                    ]);
                    ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
