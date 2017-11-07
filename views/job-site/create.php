<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\JobSite */

$this->title = 'Create Job Site';
$this->params['breadcrumbs'][] = ['label' => 'Job Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-site-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
