<?php

/* @var $this yii\web\View */

?>
<section class="home">
    <img src="/img/bg_home.jpg" alt="">
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4"><?= $this->params['page']->h1 ?></h1>
            <div class="lead my-4"><?= $this->params['page']->text ?></div>
            <p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="embed-responsive embed-responsive-16by9 my-5">
                    <iframe class="embed-responsive-item" src="<?= Yii::$app->params['video'] ?>" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="social my-5">
    <div class="container">
        <div class="h1"><?= Yii::t('app', 'Join us') ?></div>
        <div class="row justify-content-center">
            <div class="col-auto mt-4">
                <a href="<?= Yii::$app->params['facebook']['link'] ?>"><img src="/img/facebook.png" alt="Facebook"></a>
                <?php /*<div class="mt-2"><?= Yii::t('app', '<span>{0}</span> followers', Yii::$app->params['facebook']['count']) ?></div>*/ ?>
            </div>
            <div class="col-auto mt-4">
                <a href="<?= Yii::$app->params['youtube']['link'] ?>"><img src="/img/youtube.png" alt="Youtube"></a>
                <?php /*<div class="mt-2"><?= Yii::t('app', '<span>{0}</span> followers', Yii::$app->params['youtube']['count']) ?></div>*/ ?>
            </div>
            <div class="col-auto mt-4">
                <a href="<?= Yii::$app->params['twitter']['link'] ?>"><img src="/img/twitter.png" alt="Twitter"></a>
                <?php /*<div class="mt-2"><?= Yii::t('app', '<span>{0}</span> followers', Yii::$app->params['twitter']['count']) ?></div>*/ ?>
            </div>
        </div>
    </div>
</section>