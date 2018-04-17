<?php
use common\widgets\Alert;
use yii\helpers\Html;

echo Alert::widget();
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/lib/jquery/dist/jquery.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/src.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/save-form.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/set-data.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/save-pdf-content.js', ['position' => \yii\web\View::POS_END]);
$this->title = $form['name'];
?>
<div class="content-user-data">
    <?php if (!empty($form)) : ?>
        <p>
            <?= Html::a('<i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back', ['/'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Download PDF <i class="fa fa-download" aria-hidden="true"></i>', ['/site/set-pdf', 'fid' => $form['id'], 'id' => $id], ['class' => 'btn btn-success pdf-d', 'target' => '_blank']) ?>
        </p>
        <div class="demo" id="user-view">
            <?= \yii\helpers\Html::decode($form['html']) ?>
        </div>
<!--        <h1>PDF content</h1>-->
        <div  id="pdf-content" style="display:none;">
            <?= \yii\helpers\Html::decode($form['html']) ?>
        </div>
    <?php else: ?>
        <h1>No data</h1>
    <?php endif; ?>
</div>
<script>
    var _Form_id = "<?=!empty($form['id']) ? $form['id'] : null?>";
    var _Id = "<?=!empty($id) ? $id : null?>";
    var _Pdf = "<?=!empty($pdf) ? $pdf : null?>";
    var _Zip = "<?=!empty($zip) ? $zip : null?>";
</script>
`