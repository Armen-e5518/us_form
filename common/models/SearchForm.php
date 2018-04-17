<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "search_form".
 *
 * @property integer $id
 * @property integer $form_id
 * @property string $column_name
 * @property string $column_label
 *
 * @property Forms $form
 */
class SearchForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'search_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id'], 'integer'],
            [['column_name', 'column_label'], 'string', 'max' => 255],
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
            'column_name' => 'Column Name',
            'column_label' => 'Column Label',
        ];
    }

    public static function SaveFormSearchColumn($form_id, $column_name, $c_name)
    {
        if (!empty($form_id) && !empty($column_name)) {
            $model = new self();
            $model->form_id = $form_id;
            $model->column_name = $column_name;
            if ($column_name != 'user_last_name_1' && $column_name != 'user_first_name_1' && $column_name != 'user_email_1') {
                $model->column_label = $c_name;
            }
            return $model->save();
        }
        return false;
    }

    public static function DeleteFormSearchColumn($form_id)
    {
        if (!empty($form_id)) {
            return self::deleteAll(['form_id' => $form_id]);
        }
        return false;
    }

    public static function GetColumnNameByFormId($form_id)
    {
        if (!empty($form_id)) {
            return self::findAll(['form_id' => $form_id]);
        }
        return [];
    }
    public static function GetColumnNameByFormIdArray($form_id)
    {
        if (!empty($form_id)) {
            return self::find()->select('column_name')->where(['form_id' => $form_id])->asArray()->column();
        }
        return [];
    }

    public static function GetColumnNameByFormIdArrayByLabel($form_id)
    {
        if (!empty($form_id)) {
            $data = self::findAll(['form_id' => $form_id]);
            $new_col = [];
            foreach ($data as $col) {
                if (!empty($col['column_label'])) {
                    array_push($new_col, $col['column_label']);
                } else {
                    array_push($new_col, $col['column_name']);
                }
            }
            return $new_col;
        }
        return [];
    }

    public static function GetLabelsByFormId($form_id)
    {
        if (!empty($form_id)) {
            return self::find()->select(['column_label','column_name'])->where(['form_id' => $form_id])->indexBy('column_name')->column();
        }
        return [];
    }
}
