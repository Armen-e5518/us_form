<?php
use common\widgets\Alert;
use yii\helpers\Html;
use kartik\widgets\Select2;

/* @var $this yii\web\View */

$this->registerCssFile('https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerCssFile('https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css');

$this->registerJsFile('//code.jquery.com/jquery-1.12.4.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js', ['position' => \yii\web\View::POS_END]);


$this->registerJsFile(Yii::$app->urlManager->baseUrl . '/js/table/form-data-table.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl . '/js/table/form-data-index.js', ['position' => \yii\web\View::POS_END]);
//dmstr\web\AdminLteAsset::register($this);


$this->title = 'Data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="search">
            <form id="form-index" method="post" action="">
                <?= Select2::widget([
                    'id' => 'form-select',
                    'value' => !empty($post['form']) ? $post['form'] : null,
                    'name' => 'form',
                    'data' => $forms,
                    'options' => [
                        'placeholder' => 'Select form ...',
                    ],
                ]); ?>
            </form>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive">
            <table id="form-data-table" class="table" cellspacing="0">
                <thead>
                <tr class="success">
                    <th>Date</th>
                    <th>Form Name</th>
                    <th>User First Name</th>
                    <th>User Last Name</th>
                    <th>E-mail</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($forms_data)): ?>
                    <?php foreach ($forms_data as $kay => $data): ?>
                        <tr class="success">
                            <td><?= $data['date'] ?></td>
                            <td><?= $data['name'] ?></td>
                            <td><?= $data['user_first_name_1'] ?></td>
                            <td><?= $data['user_last_name_1'] ?></td>
                            <td><?= $data['user_email_1'] ?></td>
                            <td>
                                <?php if ($super_admin): ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                        ['/site/delete', 'fid' => $data['fid'], 'id' => $data['id']],
                                        [
                                            'class' => 'btn btn-success',
                                        ]) ?>
                                <?php endif; ?>
                                <?= Html::a('<span class="glyphicon glyphicon-save"></span>',
                                    ['/users-form/form', 'fid' => $data['fid'], 'id' => $data['id'], 'zip' => 1],
                                    [
                                        'class' => 'btn btn-success',
//                                        'target' => '_blank',
                                    ]) ?>
                                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                    ['/users-form/form', 'fid' => $data['fid'], 'id' => $data['id']],
                                    [
                                        'class' => 'btn btn-success',
                                    ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table
        </div>
    </div>
</div>
