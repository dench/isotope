<?php

/* @var $this yii\web\View */

?>
<section class="home">
    <div class="container">

    </div>
</section>
<section class="about">
    <div class="container">
        <h1><?= $this->params['page']->h1 ?></h1>
        <div class="text">
            <?= $this->params['page']->text ?>
        </div>
        <iframe src="<?= Yii::$app->params['video'] ?>" frameborder="0" allowfullscreen></iframe>
    </div>
</section>
<section class="social">
    <div class="container">
        <div class="h1"><?= Yii::t('app', 'Join us') ?></div>
        <div class="row">
            <div class="col">
                <a href="<?= Yii::$app->params['facebook']['link'] ?>"><img src="/img/facebook.png" alt="Facebook"></a>
                <div><?= Yii::t('app', '<span>{0}</span> followers', Yii::$app->params['facebook']['count']) ?></div>
            </div>
            <div class="col">
                <a href="<?= Yii::$app->params['youtube']['link'] ?>"><img src="/img/youtube.png" alt="Youtube"></a>
                <div><?= Yii::t('app', '<span>{0}</span> followers', Yii::$app->params['youtube']['count']) ?></div>
            </div>
            <div class="col">
                <a href="<?= Yii::$app->params['twitter']['link'] ?>"><img src="/img/twitter.png" alt="Twitter"></a>
                <div><?= Yii::t('app', '<span>{0}</span> followers', Yii::$app->params['twitter']['count']) ?></div>
            </div>
        </div>
    </div>
</section>