<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-7 col-lg-5 col-lx-4">
            <div class="card text-white bg-dark mb-4">
                <div class="card-header">
                    <h1><?= Yii::t('app', 'Log In') ?></h1>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <?= Html::submitButton(Yii::t('app', 'Log in'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>