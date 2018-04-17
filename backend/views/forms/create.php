<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Forms */
$this->registerJsFile('//code.jquery.com/jquery-1.12.4.js', ['position' => \yii\web\View::POS_END]);
$this->title = 'Create Forms';
$this->params['breadcrumbs'][] = ['label' => 'Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
