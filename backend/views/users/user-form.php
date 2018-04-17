<?php
use kartik\widgets\Select2;
use common\widgets\Alert;
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/jquery/jquery.js');
echo Alert::widget();
$this->title = 'Users Forms';
?>

<div class="row user-form">
    <div class="col-md-12">
        <div class="col-md-4 user-name-title"><span>Admin</span></div>
        <div class="col-md-6 user-form">Form</div>
    </div>
    <form action="" method="POST">
        <?php foreach ($users as $user): ?>
            <div class="col-md-12">
                <input type="hidden" name="post" value="post">
                <div class="col-md-4 user-name"><span><?= $user['username'] ?></span></div>
                <div class="col-md-6 user-form">
                    <?= Select2::widget([
                        'value' => !empty($value[$user['id']])?$value[$user['id']]:[],
                        'name' => 'forms[' . $user['id'] . ']',
                        'data' => !empty($forms)?$forms:[],
                        'options' => [
                        'placeholder' => 'Select forms ...',
                        'multiple' => true
                    ],
                    ]); ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="col-md-12 user-form-button">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>

