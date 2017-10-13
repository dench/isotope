<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 07.03.17
 * Time: 20:25
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;
use app\assets\CommonAsset;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <nav class="navbar navbar-expand-sm bg-light mb-3">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?= Nav::widget([
                    'options' => ['class' => 'mr-auto'],
                    'items' => [
                        ['label' => Yii::t('app', 'Pages'), 'url' => ['/admin/page/default/index']],
                        ['label' => Yii::t('app', 'Setting'), 'url' => '#', 'items' => [

                        ]],
                        ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
                    ],
                ]);
                ?>
                <?= Nav::widget([
                    'items' => [
                        ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
                        '<li class="nav-item">' . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(Yii::t('app', 'Logout'), ['class' => 'nav-link'])
                        . Html::endForm() . '</li>',
                    ],
                ]);
                ?>
            </div>
        </div>
    </nav>
    <?php
    if (isset($this->params['breadcrumbs'])) {
        echo Html::tag('div', Breadcrumbs::widget([
            'tag' => 'ol',
            'links' => $this->params['breadcrumbs'],
            'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
            'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
        ]), ['class' => 'container']);
    }
    ?>
    <div class="container">

        <?= Alert::widget() ?>

        <?= $content ?>
    </div>
</div>
<footer class="footer footer-inverse bg-inverse py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4 text-center">
                <div class="copyright">
                    © DaLi 2017
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
