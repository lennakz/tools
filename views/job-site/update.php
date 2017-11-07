<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobSite */

$this->title = 'Update Job Site: ' . $model->street;
$this->params['breadcrumbs'][] = ['label' => 'Job Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->street, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-site-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
