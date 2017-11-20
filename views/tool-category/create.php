<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ToolCategory */

$this->title = 'Create Tool Category';
$this->params['breadcrumbs'][] = ['label' => 'Tool Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
