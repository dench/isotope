<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $home bool */

use app\assets\SiteAsset;
use dench\language\models\Language;
use dench\language\widgets\Lang;
use yii\helpers\Html;
use yii\helpers\Url;

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
<body<?= isset($this->params['class_page']) ? ' class="' . $this->params['class_page'] . '"' : '' ?>>
<?php $this->beginBody() ?>
<div class="page-container">
    <nav class="navbar">
        <div class="container">
            <a class="brand" href="<?= Url::home() ?>"><img src="/img/rad_icon.png" alt="Isotopium"></a>
            <div class="toggle">
                <ul>
                    <li class="active"><a href="<?= Url::to(['site/page', 'slug' => 'about']) ?>">About game</a></li>
                    <li><a href="<?= Url::to(['gallery/index']) ?>">Gallery</a></li>
                    <li><a href="<?= Url::to(['blog/index']) ?>">Blog</a></li>
                </ul>
                <ul>
                    <!--<li><a href="<?= Url::to(['site/signin']) ?>">Sign in</a></li>
                    <li><a href="<?= Url::to(['site/signup']) ?>">Sign up</a></li>-->
                    <li class="dropdown">
                        <a><?= Language::$current->name ?></a>
                        <?= Lang::widget([
                            'id' => null,
                            'tag' => 'div',
                            'options' => [],
                            'itemTag' => null,
                            'linkOptions' => [],
                            'current' => Language::getCurrent(),
                            'langs' => Language::nameList(),
                        ]) ?>
                    </li>
                </ul>
            </div>
            <button><i></i><i></i><i></i></button>
        </div>
    </nav>
    <?= $content ?>
</div>
<footer>
    <div class="container">
        <a href="<?= Url::home() ?>">Isotopium: Chernobyl</a> © 2017
    </div>
</footer>
<?= $this->render('_counters') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
