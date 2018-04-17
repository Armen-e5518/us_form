<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "pdf_data".
 *
 * @property integer $id
 * @property integer $form_id
 * @property integer $data_id
 * @property string $content
 */
class PdfForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pdf_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'data_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'data_id' => 'Data ID',
            'content' => 'Content',
        ];
    }

    public static function GetPdfContentByFormIdDataId($form_id = null, $data_id = null)
    {
        if (!empty($form_id) && !empty($data_id)) {
            return self::findOne(['form_id' => $form_id, 'data_id' => $data_id]);
        }
    }

    public static function SavePdfContent($form_id = null, $data_id = null, $content)
    {
        if (!empty($form_id) && !empty($data_id)) {
            $model = self::findOne(['form_id' => $form_id, 'data_id' => $data_id]);
            if (empty($model)) {
                $model = new  self();
                $model->form_id = $form_id;
                $model->data_id = $data_id;
                $model->content = Html::encode($content);;
                return $model->save();
            } else {
                $model->content = Html::encode($content);;
                return $model->save();
            }

        }
    }
}
