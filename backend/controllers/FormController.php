<?php
namespace backend\controllers;


use common\components\Helper;
use common\models\Dynamic;
use common\models\Forms;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


/**
 * Form Controller
 */
class FormController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index',
                    'update',
                    'delete',
                    'clone',
                    'send-mail',
                    'view'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->urlManager->baseUrl . '/site/login');
        }
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->layout = false;
        return $this->render('index');
    }

    public function actionView($id)
    {
        $post = Yii::$app->request->post();
        $post = Helper::FileUpload($_FILES, $post);
        if (!empty($post)) {
            $model = new Dynamic();
            $model->RunModel('form_' . $id, $post);
            if ($model->SaveData()) {
                Yii::$app->session->setFlash('success', 'Saved...');
            } else {
                Yii::$app->session->setFlash('error', 'Error...');
            }
        }
        return $this->render('view', [
            'form' => Forms::GetFormById($id),
            'id' => $id,
        ]);
    }

    public function actionUpdate($id)
    {
        $this->layout = false;
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model = new Dynamic();
            $model->RunModel('form_' . $id, $post);
            if ($model->SaveData()) {
                Yii::$app->session->setFlash('success', 'Saved...');
            } else {
                Yii::$app->session->setFlash('error', 'Error...');
            }
        }
        return $this->render('update', [
            'form' => Forms::GetFormById($id),
            'id' => $id,
        ]);
    }

    public function actionClone($id)
    {
        $this->layout = false;
        return $this->render('clone', [
            'form' => Forms::GetFormById($id),
        ]);
    }
}
