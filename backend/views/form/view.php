<?php
use common\widgets\Alert;
echo Alert::widget();
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/lib/jquery/dist/jquery.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/src.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/save-form.js', ['position' => \yii\web\View::POS_END]);
$this->title = $form['name'];
?>

<div class="demo" id="user-view">
    <form  id="data-form" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="form_id" value="<?= $id ?>">
        <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s"); ?>">
        <?= \yii\helpers\Html::decode($form['html']) ?>
        <div class="save-button">
           <button  id="save-data" type="button" class="btn btn-success">Save Data</button>
        </div>
    </form>
</div>
<script>
    var _Id = "<?=!empty($form['id'])?$form['id']:null?>";
</script>
