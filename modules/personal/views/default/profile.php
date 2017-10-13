<?php

use app\models\Country;
use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */

$this->title = Yii::t('app', 'Edit profile');

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
                    <?= Yii::t('app', 'Personal') ?>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'username')->textInput() ?>
                    <?= $form->field($model, 'sex')->dropDownList(User::sexList()) ?>
                    <?= $form->field($model, 'birthday')->widget(MaskedInput::className(), [
                        'clientOptions' => ['alias' =>  'yyyy-mm-dd']
                    ]) ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <?= Yii::t('app', 'Location') ?>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'country_id')->dropDownList(Country::getList()) ?>
                    <?= $form->field($model, 'city')->textInput() ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <?= Yii::t('app', 'Other') ?>
                </div>
                <div class="card-body">
                    <?= $form->field($model, 'website')->textInput() ?>
                    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
