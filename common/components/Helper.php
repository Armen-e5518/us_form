<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/20/17
 * Time: 12:42 PM
 */

namespace common\components;


use backend\models\FormsData;
use common\models\Forms;
use common\models\PdfForm;
use common\models\User;
use kartik\mpdf\Pdf;

class Helper
{

    public static function Out($x)
    {
        echo '<pre>';
        print_r($x);
        echo '</pre>';
    }

    public static function FileUpload($file, $post)
    {
        if (!empty($file)) {
            $arr = [];
            $flag = true;
            foreach ($file as $name => $value) {
                if (!empty($value['name'])) {
                    $target_dir = \Yii::$app->params['root_path'] . 'backend/web/uploads/';
                    $name_array = explode(".", basename($file[$name]["name"]));
                    $filename = pathinfo($file[$name]['name'], PATHINFO_FILENAME);
                    $filename = preg_replace('/[^A-Za-z0-9 _ .-]/', '_', $filename);
                    $filename .= rand(1, 100);
                    $format = end($name_array);
                    $target_file = $target_dir . $filename . '.' . $format;
                    if (!move_uploaded_file($file[$name]["tmp_name"], $target_file)) {
                        $flag = false;
                    } else {
                        $arr[$name] = $filename . '.' . $format;
                    }
                }
            }
            if ($flag) {
                foreach ($arr as $k => $f_name) {
                    $post[$k] = $f_name;
                }
            }
        }

        return $post;
    }

    public static function CheckFormIdByUrl($url)
    {
        if (!empty($url)) {
            $model = Forms::GetFormIdByUrl($url);
            if (!empty($model)) {
                return $model['id'];
            };
        }
        return null;
    }

    public static function GetZipUrl($form_id = null, $form_data_id = null)
    {
        if (!empty($form_id) && !empty($form_data_id)) {
            $pdf = self::SavePdf($form_id, $form_data_id);
            $data = FormsData::GetFormDataByFormIdByDataId($form_id, $form_data_id);
            if (!empty($data)) {
                $flag = false;
                $phat = \Yii::$app->basePath . '/web/uploads/';
                $zip_file = $phat . 'zip/' . $data['user_first_name_1'] . '_' . $data['user_last_name_1'] . '_' . $form_id . '_' . $form_data_id . '.zip';
                if (file_exists($zip_file)) {
                    unlink($zip_file);
                }
                fopen($zip_file, 'w');
                $zip = new \ZipArchive();
                if ($zip->open($zip_file, \ZipArchive::CREATE) !== TRUE) {
                    throw new \Exception('Cannot create a zip file');
                }
                if (!empty($pdf)) {
                    $zip->addFile($pdf['path'], $pdf['name']);
                }

                foreach ($data as $kay => $d) {

                    if ((!(strripos($kay, 'file_') === false) && $d != null)) {
                        $zip->addFile($phat . $d, $d);
                        $flag = true;
                    }
                }
                $zip->close();
                return [
                    'zip' => $zip_file,
                    'flag' => $flag,
                ];
            }
        }
        return null;
    }

    public static function SendMail($post = null, $form_id = null, $id = null)
    {
        if (!empty($post) && !empty($form_id) && !empty($id)) {
            $email_data = Forms::GetEmailDataById($form_id);
            $Subject = !empty($email_data['email_subject']) ? $email_data['email_subject'] : 'Thanks';
            $Body = !empty($email_data['email_text']) ? $email_data['email_text'] : 'Thanks';
            foreach ($post as $kay => $data) {
                if (!(strripos($kay, 'user_email') === false)) {
                    return \Yii::$app->mailer->compose()
                        ->setFrom($email_data['email'])
                        ->setTo($data)
                        ->setSubject($Subject)
                        ->setTextBody($Body)
                        ->send();
                }
            }
        }
        return false;
    }

    public static function SendMailAdmin($post = null, $form_id = null, $id = null)
    {
        if (!empty($post) && !empty($form_id) && !empty($id)) {
            $email_data = Forms::GetEmailDataById($form_id);
            $Subject = 'New User Data';
            $pdf = \Yii::$app->params['domain'] . '/forms/admin/users-form/form?fid=' . $form_id . '&id=' . $id . '&pdf=1';
            $Body = '<a href="' . $pdf . '">Download Pdf</a>';
            return \Yii::$app->mailer->compose()
                ->setFrom(\Yii::$app->params['mail']['from'])
                ->setTo($email_data['email'])
                ->setSubject($Subject)
                ->setHtmlBody($Body)
                ->send();

        }
        return false;
    }

    public static function GetFileArrayByData($data = null)
    {
        if (!empty($data)) {
            foreach ($data as $kay => $d) {
                if ((!(strripos($kay, 'file_') === false))) {

                }
            }
        }
    }

    public static function SavePdf($fid, $id)
    {
        if (empty($fid) && empty($id)) {
            return false;
        }

        $form_data = FormsData::GetFormDataByFormIdByDataId($fid, $id);
        $content = \Yii::$app->controller->renderPartial('pdf-content', [
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
                'SetHeader' => [$form_data['user_first_name_1'] . ' ' . $form_data['user_last_name_1'] . ' ' . date('Y-m-d')],
                'SetFooter' => ['U.S. Embassy in Armenia | {PAGENO} | dev'],
            ]
        ]);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'application/pdf');
        // return the pdf output as per the destination setting
        $path_pdf = $target_dir = \Yii::$app->basePath . '/web/uploads/pdfs/';
        $file_name = $form_data['user_first_name_1'] . '_' . $form_data['user_last_name_1'] . '_' . date('Y-m-d').'.pdf';
        $full_phath = $path_pdf . $file_name;
        fopen($full_phath, 'a+');
        if (file_put_contents($full_phath, $pdf->Output($content, 'pdf.pdf', 'S'))) {
            return [
                'path' => $full_phath,
                'name' => $file_name
            ];
        };
        return false;
    }

}