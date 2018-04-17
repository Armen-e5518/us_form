<?php
namespace common\models;

use common\models\Forms;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Expression;


class Dynamic extends ActiveRecord
{

    public $table_name;

    public $data;


    public function RunModel($table_name, $data)
    {
        $this->table_name = $table_name;
        $this->data = $data;
    }

    public function SaveData()
    {
        if (!empty($this->data)) {
            if (!empty(Forms::FormExistById($this->data['form_id']))) {
                return \Yii::$app->db->createCommand()
                    ->insert($this->table_name, $this->data)
                    ->execute();
            }
        }
        return false;
    }

}