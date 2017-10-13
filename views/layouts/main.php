<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $home bool */

use app\assets\SiteAsset;
use app\widgets\Alert;
use dench\language\models\Language;
use dench\language\widgets\Lang;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

SiteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body<?= isset($this->params['class_page']) ? ' class="' . $this->params['class_page'] : '"' ?>">
<?php $this->beginBody() ?>
<div class="page-container">
    <nav class="navbar navbar-expand-sm navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= Url::home() ?>" title="<?= Yii::$app->name ?>">
                <img src="/img/rad_icon.png" width="38" height="38" alt="<?= Yii::$app->name ?>">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/site/page', 'slug' => 'about']) ?>">About game <span class="sr-only">(current)</span></a>
                    </li>
                    <?php /*<li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/gallery/index']) ?>">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/blog/index']) ?>">Blog</a>
                    </li>*/ ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/login']) ?>">Log in</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/signup']) ?>">Sign up</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/personal/default/index']) ?>">Account</a></li>
                        <li class="nav-item"><?= Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(Yii::t('app', 'Logout'), ['class' => 'nav-link'])
                            . Html::endForm() ?></li>
                    <?php endif; ?>
                    <?php
                    /*<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-sm-none d-md-inline"><?= Language::$current->name ?></span>
                            <span class="d-none d-sm-inline d-md-none "><?= Language::$current->id ?></span>
                        </a>
                        <?= Lang::widget([
                            'id' => null,
                            'tag' => 'div',
                            'options' => [
                                'class' => 'dropdown-menu',
                            ],
                            'itemTag' => null,
                            'linkOptions' => [
                                'class' => 'dropdown-item',
                            ],
                            'current' => Language::getCurrent(),
                            'langs' => Language::nameList(),
                        ]) ?>
                    </li>
                    */
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <?= Alert::widget() ?>
    <?php
    if (isset($this->params['breadcrumbs'])) {
        echo Html::tag('div', Breadcrumbs::widget([
            'tag' => 'ol',
            'links' => $this->params['breadcrumbs'],
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
            'homeLink' => [
                'label' => Yii::$app->name,
                'url' => Yii::$app->homeUrl,
            ],
        ]), ['class' => 'container']);
    }
    ?>
    <?= $content ?>
</div>
<footer>
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <a href="<?= Url::home() ?>"><?= Yii::$app->name ?></a> © <?= Yii::$app->params['years'] ?><br>
                Created by <a href="https://www.remotegames.net" target="_blank">RemoteGames</a>
            </div>
        </div>
    </div>
</footer>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
