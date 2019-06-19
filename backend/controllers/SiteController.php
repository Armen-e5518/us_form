<?php

namespace backend\controllers;


use backend\components\DataChange;
use backend\models\FormsData;
use common\components\Helper;
use common\models\Forms;
use common\models\PdfForm;
use backend\models\ResetPassword;
use common\models\SearchForm;
use common\models\UsersForms;
use kartik\mpdf\Pdf;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'error',
                            'save-zip-file',
                            'save', 'no-file',
                            'form',
                            'set-pdf',
                            'save-pdf',
                            'dom',
                            'reset-password',
                            'css',
                            'delete',
                            'delete-in-form',
                            'info'
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
            ],
        ];
    }

    public function beforeAction($action)
    {

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionInfo()
    {
        phpinfo();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        if (Yii::$app->request->post()) {
            return $this->redirect(['form', 'id' => Yii::$app->request->post('form')]);
        }
        return $this->render('index', [
            'forms' => Forms::GetAllForms(),
            'forms_data' => FormsData::GetAllDataForms(null),
            'post' => null,
            'super_admin' => (UsersForms::GetUsersFormsByThisUser()['rol'] == 'SUPER_ADMIN') ? true : false,
        ]);
    }

    public function actionDelete($fid, $id)
    {
        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'SUPER_ADMIN') {
            if (FormsData::DeleteFormDataById($fid, $id)) {
                Yii::$app->session->setFlash('success', 'Deleted...');
            } else {
                Yii::$app->session->setFlash('error', 'Data was not deleted...');
            }
        }
        return $this->goHome();
    }

    public function actionDeleteInForm($fid, $id)
    {
        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'SUPER_ADMIN') {
            if (FormsData::DeleteFormDataById($fid, $id)) {
                Yii::$app->session->setFlash('success', 'Deleted...');
                return $this->redirect(['form', 'id' => $fid]);
            }
            Yii::$app->session->setFlash('error', 'Data was not deleted...');
            return $this->redirect(['form', 'id' => $fid]);
        }
        return $this->goHome();
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionCss()
    {
        $file = $target_dir = \Yii::$app->basePath . '/web/css/src.css';
        $post = Yii::$app->request->post();
        if ($post) {
            file_put_contents($file, $post['css']);
        }
        return $this->render('css', [
            'data' => file_get_contents($file)
        ]);
    }

    public function actionForm()
    {
        $id = !empty(Yii::$app->request->get()) ? Yii::$app->request->get('id') : null;
        if (empty($id)) {
            $this->redirect(Yii::$app->urlManager->baseUrl);
        }
        $column = SearchForm::GetColumnNameByFormIdArray($id);
        $column_label = SearchForm::GetColumnNameByFormIdArrayByLabel($id);
        return $this->render('form', [
            'form' => Forms::GetFormById($id),
            'forms' => Forms::GetAllForms(),
            'forms_data' => FormsData::GetFormDataByFormId($id),
            'search_field' => $column,
            'search_normal_field' => DataChange::ColumnsNameByNormal($column_label),
            'form_id' => $id,
            'super_admin' => (UsersForms::GetUsersFormsByThisUser()['rol'] == 'SUPER_ADMIN') ? true : false,
        ]);
    }

    public function actionSaveZipFile($fid, $id)
    {
        if (!empty($fid) && !empty($id)) {
            $file = Helper::GetZipUrl($fid, $id);
            if (file_exists($file['zip']) && $file['flag']) {
                return Yii::$app->response->sendFile((string)$file['zip']);
            } else {
                return $this->redirect(Yii::$app->urlManager->baseUrl . '/site/no-file');
            }
        }
    }

    public function actionResetPassword()
    {

        $model = new  ResetPassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->Reset()) {
                Yii::$app->session->setFlash('success', 'Password saved...');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Password was not saved...');
            }

        }
        return $this->render('reset-password', [
            'model' => $model
        ]);
    }

    public function actionNoFile()
    {
        return $this->render('no-file');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSetPdf($fid, $id)
    {

        if (empty($fid) || empty($id)) {
            $this->redirect('/admin/site/');
        }
        $this->layout = false;
        $form_data = FormsData::GetFormDataByFormIdByDataId($fid, $id);

//        Helper::Out($form_data);
        $content = $this->renderPartial('pdf-content', [
            'form' => PdfForm::GetPdfContentByFormIdDataId($fid, $id),
        ]);

        $pdf = new Pdf([
// set to use core fonts only
            'mode' => Pdf::MODE_CORE,
// A4 paper format
            'format' => Pdf::FORMAT_A4,
// portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
// stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
// your html content input
            'content' => $content,
// format content from your own css file if needed or use the
//             enhanced bootstrap css built by Krajee for mPDF formatting
//            'cssFile' => '@web/css/pdf-css.css',
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
//            'cssInline' => '.kv-heading-1{font-size:18px}',
// set mPDF properties on the fly
            'options' => ['title' => 'U.S. Embassy in Armenia ' . date('YY-MM-DD')],
// call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [$form_data['user_first_name_1'] . ' ' . $form_data['user_last_name_1'] .' '. date('Y-m-d')],
                'SetFooter' => ['U.S. Embassy in Armenia | {PAGENO} |'],
            ]
        ]);
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $headers = Yii::$app->response->headers;
//        $headers->add('Content-Type', 'application/pdf');
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

}
