<?php

namespace backend\models;

use common\models\Forms;
use common\models\SearchForm;
use common\models\UsersForms;
use Yii;
use yii\db\Query;


class FormsData extends \yii\db\ActiveRecord
{

    public static function GetFormDataById($form_id, $search)
    {
        $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $form_id);
        if (empty($tableSchema)) {
            return [];
        }
        if (!empty($form_id)) {
            $UsersForm = UsersForms::GetUsersFormsByThisUser();
            if ($UsersForm['rol'] == 'ADMIN' && !in_array($form_id, $UsersForm['data'])) {
                return [];
            }
            $query = new Query();
            $query = $query->select("*")
                ->from('form_' . $form_id);
            if (!empty($search)) {
                $search_columns = SearchForm::GetColumnNameByFormId($form_id);
                if (!empty($search_columns)) {
                    foreach ($search_columns as $column) {
                        $query->orFilterWhere(['like', $column['column_name'], $search]);
                    }
                }
            }
            return $query->createCommand()
                ->queryAll();
        }
        return [];
    }

    public static function GetFormDataByFormIdByDataId($form_id = null, $id = null)
    {
        if (!empty($form_id) && !empty($id)) {
            $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $form_id);
            if (empty($tableSchema)) {
                return [];
            }
            $UsersForm = UsersForms::GetUsersFormsByThisUser();
            if ($UsersForm['rol'] == 'ADMIN' && !in_array($form_id, $UsersForm['data'])) {
                return [];
            }
            $query = new Query();
            return $query->select("*")
                ->from('form_' . $form_id)
                ->where(['id' => $id])
                ->createCommand()
                ->queryOne();
        }
        return [];
    }

    public static function GetAllDataForms($post)
    {
        if (!empty($post['form'])) {
            $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $post['form']);
            if (empty($tableSchema)) {
                return [];
            }
            $query = new Query();
            return $query->select(
                [
                    'f.id as fid',
                    'f.name',
                    'fd.id',
                    'fd.user_first_name_1',
                    'fd.user_last_name_1',
                    'fd.user_email_1',
                    'fd.date',
                ])
                ->from('form_' . $post['form'] . ' fd')
                ->leftJoin(Forms::tableName() . ' f', 'f.id = fd.form_id')
                ->createCommand()
                ->queryAll();
        }
        $forms_ids = Forms::GetAllFormsIds();
        if (!empty($forms_ids)) {
            $query = new Query();
            foreach ($forms_ids as $kay => $id) {
                $query_new = new Query();
                $query_new->select(
                    [
                        'f.id as fid',
                        'f.name',
                        'fd.id',
                        'fd.user_first_name_1',
                        'fd.user_last_name_1',
                        'fd.user_email_1',
                        'fd.date',
                    ])
                    ->from('form_' . $id['id'] . ' fd')
                    ->leftJoin(Forms::tableName() . ' f', 'f.id = fd.form_id');
                if ($kay == 0) {
                    $query = $query_new;
                } else {
                    $query->union($query_new);
                }
            }
            return $query
                ->createCommand()
                ->queryAll();
        }
    }

    public static function GetFormDataByFormId($id)
    {
        $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $id);
        if (empty($tableSchema)) {
            return [];
        }
        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'ADMIN' && !in_array($id, $UsersForm['data'])) {
            return [];
        }
        if (!empty($id)) {
            $query = new Query();
            return $query->select("*")
                ->from('form_' . $id)
                ->createCommand()
                ->queryAll();
        }
        return [];

    }

    public static function DeleteFormDataById($form_id, $data_id)
    {
        $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $form_id);
        if (empty($tableSchema)) {
            return false;
        }
        $query = new Query();
        return $query->createCommand()
            ->delete('form_' . $form_id, ['id' => $data_id])
            ->execute();
    }
}
