<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tool */

$this->title = 'Create Tool';
$this->params['breadcrumbs'][] = ['label' => 'Tools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tool-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
