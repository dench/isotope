<?php

use himiklab\yii2\recaptcha\ReCaptcha;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $model app\models\SignupForm */

$js = <<<JS
$('#signupform-offset').each(function(){
    $(this).val((new Date).getTimezoneOffset());
});
JS;

$this->registerJs($js);

$this->title = Yii::t('app', 'Sign Up');
?>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-7 col-lg-5 col-lx-4">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <h1><?= $this->title ?></h1>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <?= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['site/auth'],
                        ]) ?>
                        <small class="text-muted">We'll never post anything on Facebook without your permission.</small>
                    </div>

                    <h2 class="text-center">OR</h2>

                    <?php $form = ActiveForm::begin(['id' => 'signupform']); ?>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                    <?= $form->field($model, 'email')->textInput() ?>

                    <?= $form->field($model, 'country_id')->dropDownList(Country::getList(), ['prompt' => Yii::t('app', 'Select...')]) ?>

                    <?= $form->field($model, 'email_news')->checkbox() ?>

                    <?= Html::activeHiddenInput($model, 'offset') ?>

                    <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className(), [
                        'theme' => ReCaptcha::THEME_DARK,
                    ])->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Sign up'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    By signing up, you agree to our <a href="#">terms of use</a>, <a href="#">privacy policy</a>, and <a href="#">cookie policy</a>.

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>