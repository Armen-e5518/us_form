<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Reset Password';

?>
<div class="login-box">
    <div class="login-box-body">

        <?php $form = ActiveForm::begin(['id' => 'reset-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => false]); ?>
        <?= $form
            ->field($model, 'password')
            ->label(false)
            ->passwordInput(['placeholder' => 'New password', 'autocomplete' => 'off']) ?>
        <?= $form
            ->field($model, 'confirm_password')
            ->label(false)
            ->passwordInput(['placeholder' => 'Confirm password', 'autocomplete' => 'off']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>