<?php

use \yii\web\View;

?>

<!DOCTYPE html>
<html>
<head>
    <script>var _baseUrl = "<?=Yii::$app->urlManager->baseUrl?>"</script>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?= Yii::$app->urlManager->baseUrl ?>/favicon.png" type="image/x-icon">
    <title>Create Form</title>
    <link href="<?= Yii::$app->urlManager->baseUrl ?>/lib/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="<?= Yii::$app->urlManager->baseUrl ?>/css/layoutit.css" rel="stylesheet">
    <link href="<?= Yii::$app->urlManager->baseUrl ?>/css/src.css" rel="stylesheet">
    <link href="<?= Yii::$app->urlManager->baseUrl ?>/css/colorpicker.css" rel="stylesheet">
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/jquery/html5shiv.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/lib/jquery/dist/jquery.min.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/jquery/jquery-ui.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/jquery/jquery.htmlClean.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/radio.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/scripts.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/src.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/save-form.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/image-set.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/Dropzone.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/color/jscolor.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/color/colorpicker.js"></script>
    <script src="<?= Yii::$app->urlManager->baseUrl ?>/js/my-ckeditor.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Oswald|Roboto|Slabo+27px|Source+Sans+Pro" rel="stylesheet">
</head>
<body style="min-height: 824px;" class="edit">
<div class="navbar navbar-inverse navbar-fixed-top navbar-layoutit">
    <div class="navbar-header">
        <button data-target="navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="glyphicon-bar"></span>
            <span class="glyphicon-bar"></span>
            <span class="glyphicon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="nav" id="menu-layoutit">
            <li>
                <div class="btn-group" data-toggle="buttons-radio">
                    <button type="button" id="admin" class=" btn btn-xs btn-primary">
                        <i class=" glyphicon glyphicon-user"></i>
                        Admin
                    </button>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="row">
        <?= View::render('/common/left-bar.php', [
            'form_name' => !empty($form['name']) ? $form['name'] : '',
        ]); ?>

        <div style="min-height: 754px;" id="html-data" class="demo demo-edit ui-sortable">
            <div class="lyrow ui-draggable" style="display: block;"></div>
        </div>
        <div id="download-layout">
            <div class="container"></div>
        </div>

    </div>
</div>

<div style="display: none;" class="modal fade" id="downloadModal" tabindex="-1" role="dialog"
     aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="download-logged" class="">
                    <p>
                        <textarea></textarea>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<span class="right-text">Right click to change text</span>
<script>
    var _Id = "<?=!empty($form['id']) ? $form['id'] : null?>";
</script>
</body>

</html>