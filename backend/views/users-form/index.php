<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FormsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJsFile('//code.jquery.com/jquery-1.12.4.js', ['position' => \yii\web\View::POS_END]);
$this->title = 'Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= GridView ::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                    'id',
                    [
                        'attribute' => 'url',
                        'value' => function($model){
                            return '<a target="_blank" href="'.$model->url.'">'.$model->url.'</a>';
                        },
                        'format' => 'raw'
                    ],
                    'name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Data',
//                        'headerOptions' => ['style' => 'color:#337ab7'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-view'),
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-update'),
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'lead-delete'),
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'view') {
                                $url =Yii::$app->urlManager->baseUrl.'/users-form/form-data?id='.$model->id;
                                return $url;
                            }
                            if ($action === 'update') {
                                $url =Yii::$app->urlManager->baseUrl.'/form/update?id='.$model->id;
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url =Yii::$app->urlManager->baseUrl.'/forms/delete?id='.$model->id;
                                return $url;
                            }
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
