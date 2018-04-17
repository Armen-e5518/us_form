<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->registerCssFile('https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/jquery/jquery-3.1.1.js');
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/jquery/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/form-data-table.js', ['position' => \yii\web\View::POS_END]);

$this->title = 'Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3"><?= Html::a('<i class="fa fa-long-arrow-left" aria-hidden="true"></i> All data ', ['/users-form'], ['class' => 'btn btn-success']) ?></div>
    <div class="col-md-4">
        <div class="search">
            <form method="post" action="">
                <input value="<?=$search?>" name="search" placeholder="text" type="text">
                <?= Html::submitButton('Search <i class="fa fa-search" aria-hidden="true"></i>', ['class' => 'btn btn-success']) ?>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class=" col-md-7">
        <table id="form-data-table" class="table">
            <thead>
            <tr class="success">
                <th>ID</th>
                <th>Form name</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($form_data)): ?>
                <?php foreach ($form_data as $kay => $data): ?>
                    <tr class="success">
                        <td><?= $data['id'] ?></td>
                        <td>  <?= Html::a("User ".($kay+1), ['/users-form/form','fid' => $data['form_id'],'id' => $data['id'],], ['class' => '']) ?> </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table
    </div>
</div>
