<?php
namespace backend\controllers;

use backend\models\FormsData;
use backend\models\TableBuilder;
use common\models\Forms;
use common\models\PdfForm;
use common\models\SearchForm;
use yii\web\Controller;

use Yii;

/**
 * Site controller
 */
class AjaxController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->params['domain'] = Yii::$app->urlManager->getHostInfo();
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCreateTableByData()
    {

        if (Yii::$app->request->isAjax) {
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $form = new  TableBuilder();
                $form->CreateTableByData($post[0]['id'], $post);
            }
        }
    }

    public function actionSaveForm()
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                return Forms::SaveForm($post);
            }
        }
    }

    public static function actionGetFormDataById()
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                return FormsData::GetFormDataByFormIdByDataId($post['form_id'], $post['id']);
            }
        }
    }

    public static function actionSavePdfContent()
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                return PdfForm::SavePdfContent($post['form_id'], $post['id'], $post['content']);
            }
        }
    }

    public static function actionGetColumnNames()
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                return SearchForm::GetLabelsByFormId($post['form_id']);
            }
        }
    }
}
