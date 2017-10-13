<?php
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->params['page']->name;
?>
<div class="container">
    <h1><?= $this->params['page']->h1 ?></h1>
    <?= $this->params['page']->text ?>
</div>