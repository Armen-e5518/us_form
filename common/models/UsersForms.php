<?php

namespace common\models;

use backend\models\Users;
use common\components\Helper;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "users_forms".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $form_id
 */
class UsersForms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'form_id'], 'required'],
            [['user_id', 'form_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'form_id' => 'Form ID',
        ];
    }

    public static function SaveUsersForms($data)
    {
        if (isset($data)) {
            $flag = true;
            self::deleteAll();
            if (!empty($data['forms'])) {
                foreach ($data['forms'] as $user_id => $forms) {
                    foreach ($forms as $form_id) {
                        $model = new self();
                        $model->user_id = (int)$user_id;
                        $model->form_id = (int)$form_id;
                        if (!$model->save()) {
                            $flag = false;
                        }
                    }
                }
            }
            return $flag;
        }
        return false;
    }

    public static function GetUsersForms()
    {
        $data = self::find()->select(['user_id', 'form_id'])->asArray()->all();
        if (!empty($data)) {
            $res = [];
            foreach ($data as $d) {
                $res[$d['user_id']][] = $d['form_id'];
            }
            return $res;
        }
        return [];
    }

    public static function GetUsersFormsByThisUser()
    {
        return [
            'rol' => (User::getUserStatus() == 'SUPER_ADMIN') ? "SUPER_ADMIN" : 'ADMIN',
            'data' => self::find()->select('form_id')->where(['user_id' => Yii::$app->user->id])->asArray()->column()
        ];
    }
}
