<?php

namespace frontend\controllers;

use common\components\Helper;
use common\components\XmlGen;
use common\models\Dynamic;
use common\models\Forms;
use Yii;
use yii\web\Controller;


class SiteController extends Controller
{
    const XML_PHAT = 'xmls';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionGetJson()
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $xml = new XmlGen();
                return $xml->GetDataOfXml($post['content']);
            }
        }
        return null;
    }

    public function actionGetXmlFileName()
    {
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            if (!empty($post)) {
                $xml = new XmlGen();
                return urlencode($xml->GetXml($post['data'],$post['name']));
            }
        }
        return null;
    }

    public function actionDownloadXml($xml)
    {
        if (file_exists($xml)) {
            return Yii::$app->response->SendFile(urldecode($xml));
        }
        $this->redirect(['index']);
    }

    public function actionIndex()
    {
        $this->redirect('https://www.usa.am');
    }

    public function actionView($id)
    {

        $this->layout = false;
        $id_f = Helper::CheckFormIdByUrl($id);
        if (empty($id_f)) {
            echo '404 error';
            exit;
        }
        $post = Yii::$app->request->post();
        $post = Helper::FileUpload($_FILES, $post);
        if (!empty($post)) {
            $model = new Dynamic();
            $model->RunModel('form_' . $id_f, $post);
            if ($model->SaveData()) {
                $d_id = Yii::$app->db->getLastInsertID();
                Helper::SendMail($post, $id_f, $d_id);
                Helper::SendMailAdmin($post, $id_f, $d_id);
                $this->redirect(['thank', 'id' => $id]);
                Yii::$app->session->setFlash('success', 'Saved...');
            } else {
                Yii::$app->session->setFlash('error', 'Error...');
            }
        }
        return $this->render('new-view', [
            'form' => Forms::GetFormByIdView($id_f),
            'id' => $id_f,
        ]);
    }

    public function actionThank($id)
    {
        $this->layout = false;
        $id = Helper::CheckFormIdByUrl($id);
        if (empty($id)) {
            echo '404 error';
            exit;
        }
        return $this->render('thank', [
            'data' => Forms::GetFormByIdView($id),
        ]);
    }

    public function actionFrontCss()
    {
        $file = $target_dir = \Yii::$app->basePath . '/web/css/front.css';
        $post = Yii::$app->request->post();
        if ($post) {
            file_put_contents($file, $post['css']);
        }
        return $this->render('css', [
            'data' => file_get_contents($file)
        ]);
    }

    public function actionLayoutit()
    {
        $file = $target_dir = \Yii::$app->basePath . '/web/css/layoutit.css';
        $post = Yii::$app->request->post();
        if ($post) {
            file_put_contents($file, $post['css']);
        }
        return $this->render('layoutit', [
            'data' => file_get_contents($file)
        ]);
    }

    public function actionFileView()
    {
        $file = $target_dir = \Yii::$app->basePath . '/views/site/view.php';
        $post = Yii::$app->request->post();
        if ($post) {
            file_put_contents($file, $post['css']);
        }
        return $this->render('file', [
            'data' => file_get_contents($file)
        ]);
    }

}
