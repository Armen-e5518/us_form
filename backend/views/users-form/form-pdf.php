<?php
use common\widgets\Alert;

echo Alert::widget();
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/lib/jquery/dist/jquery.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/src.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/save-form.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/set-data.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/pdf.js', ['position' => \yii\web\View::POS_END]);
?>

<div class="demo" id="pdf">
    <?= \yii\helpers\Html::decode($form['html']) ?>
</div>


<script>
    var _Form_id = "<?=!empty($form['id']) ? $form['id'] : null?>";
    var _Id = "<?=!empty($id) ? $id : null?>";
</script>
