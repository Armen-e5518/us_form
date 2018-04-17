<?php
namespace backend\models;

use common\models\SearchForm;
use yii\db\Migration;


class TableBuilder extends Migration
{
    use \backend\components\TextTypesTrait;
    /**
     * @param null $form_id
     * @param null $data
     * $arr = [
     * [
     * 'name' => 'column1',
     * 'type' => 'int',
     * ],
     * [
     * 'name' => 'column2',
     * 'type' => 'int',
     * ],
     * [
     * 'name' => 'column3',
     * 'type' => 'string',
     * ],
     * [
     * 'name' => 'column4',
     * 'type' => 'int',
     * ]
     * ];
     */

    public function CreateTableByData($form_id = null, $data = null)
    {
        if (!empty($data) && !empty($form_id)) {
            $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $form_id);
            if (!empty($tableSchema)) {
                $this->dropTable('form_' . $form_id);
            }
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $sql = [
                'id' => $this->primaryKey(),
                'form_id' => $this->integer()->notNull(),
                'date' => $this->dateTime()->notNull(),
            ];
            SearchForm::DeleteFormSearchColumn($form_id);
            foreach ($data as $d) {
                if ($d['type'] == 'int') {
                    $sql[$d['name']] = $this->integer()->null();
                } else {
                    $sql[$d['name']] = $this->mediumText();
                }
                if (!empty($d['search']) && $d['search'] == 'search') {
                    SearchForm::SaveFormSearchColumn($form_id, $d['name'], $d['c_name']);
                }
            }
            $this->createTable('{{%form_' . $form_id . '}}', $sql, $tableOptions);
        }
    }

    public function DropTableById($form_id)
    {
        $tableSchema = \Yii::$app->db->schema->getTableSchema('form_' . $form_id);
        if (!empty($tableSchema)) {
            return $this->db->createCommand()->dropTable('form_' . $form_id)->execute();
        }
        return true;
    }


    protected function GetRandomTableName()
    {
        return substr(md5(microtime()), 0, 6);
    }

}