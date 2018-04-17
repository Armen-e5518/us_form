<?php
use common\widgets\Alert;
use yii\helpers\Html;

echo Alert::widget();
$this->registerCssFile('/css/usembassy/src1.css');
$this->registerCssFile('/css/src.css');
$this->registerCssFile('/css/front.css');
$this->registerJsFile('/lib/jquery/dist/jquery.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/src.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/save-form.js', ['position' => \yii\web\View::POS_END]);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<div class="container">
    <div class="row devpreview">
        <div class="demo" id="user-view">
            <form id="data-form" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form_id" value="<?= $id ?>">
                <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s"); ?>">
                <?= Html::encode(Html::encode($form['html'])) ?>
                <!--                --><? //= html_entity_decode($form['html']) ?>
                <div class="save-button">
                    <button id="save-data" type="button" class="btn btn-success">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    var _Id = "<?=!empty($form['id']) ? $form['id'] : null?>";
</script>

