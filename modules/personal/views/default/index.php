<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Account');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1 class="title"><?= $this->title ?></h1>
    <?= Html::a(Yii::t('app', 'Edit account'), ['/personal/default/account'], ['class' => 'btn btn-primary btn-lg']) ?>
    <?= Html::a(Yii::t('app', 'Edit profile'), ['/personal/default/profile'], ['class' => 'btn btn-primary btn-lg']) ?>
</div>
