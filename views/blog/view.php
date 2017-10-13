<?php
/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */

$this->params['breadcrumbs'][] = ['label' => $this->params['page']->parent->name, 'url' => ['/blog/index']];
$this->params['breadcrumbs'][] = $this->params['page']->name;
?>
<div class="container page">

    <h1><?= $this->params['page']->h1 ?></h1>

    <div class="page-text">
        <?= $this->params['page']->text ?>
    </div>
</div>