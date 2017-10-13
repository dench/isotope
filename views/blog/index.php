<?php
/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $this->params['page']->name;
?>
<div class="container page">
    <h1><?= $this->params['page']->h1 ?></h1>

    <div class="news">
        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'layout' => "<div class=\"row cards\">{items}</div>\n<div class=\"clear-pager text-center\">{pager}</div>",
            'emptyTextOptions' => [
                'class' => 'alert alert-danger',
            ],
        ]);
        ?>
    </div>

    <div class="page-text">
        <?= $this->params['page']->text ?>
    </div>
</div>