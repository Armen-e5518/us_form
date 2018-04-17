<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "forms".
 *
 * @property integer $id
 * @property string $url
 * @property string $name
 * @property string $html
 * @property string $email_subject
 * @property string $email_text
 * @property string $email
 * @property string $thank_title
 * @property string $thank_text
 *
 */
class Forms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['html','thank_text'], 'string'],
            [['url','email'], 'string', 'max' => 200],
            ['email', 'email'],
			[['time'], 'integer'],
            [['name', 'email_subject', 'email_text', 'thank_title', 'redirect_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'name' => 'Name',
            'html' => 'Html',
            'email_subject' => 'Email Subject',
            'email_text' => 'Email Text',
            'thank_title' => 'Thank you title',
            'thank_text' => 'Text',
            'email' => 'Send Email',
            'redirect_link' => 'Redirect link',
            'time' => 'Redirect time',
        ];
    }

    /**
     * @param null $data
     * @return int
     */
    public static function SaveForm($data = null)
    {
        if (!empty($data)) {
            if (!empty($data['id'])) {
                $model = self::findOne(['id' => $data['id']]);
            } else {
                $model = new self();
            }
            $model->name = (string)$data['name'];
            $model->url = md5(microtime(true));
            $model->html = Html::encode($data['html']);;
            if ($model->save()) {
                return $model->id;
            } else {
                $model->getErrors();
            }

        }
    }

    /**
     * @param $id
     * @return array|static
     */
    public static function GetFormById($id)
    {
        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'ADMIN' && !in_array($id, $UsersForm['data'])) {
            return null;
        }
        return self::findOne(['id' => $id]);
    }

    /**
     * @param $id
     * @return static
     */
    public static function GetFormByIdView($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * @param $id
     * @return static
     */
    public static function GetFormIdByUrl($id)
    {
        return self::findOne(['url' => $id]);
    }

    /**
     * @param $id
     * @return static
     */
    public static function FormExistById($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * @return array
     */
    public static function GetAllForms()
    {
        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'SUPER_ADMIN') {
            return self::find()->select(['name', 'id'])->indexBy('id')->column();
        }
        if ($UsersForm['rol'] == 'ADMIN') {
            return self::find()->select(['name', 'id'])->where(['id' => $UsersForm['data']])->indexBy('id')->column();
        }
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function GetAllFormsIds()
    {
        $UsersForm = UsersForms::GetUsersFormsByThisUser();
        if ($UsersForm['rol'] == 'SUPER_ADMIN') {
            return self::find()->select(['id', 'name'])->asArray()->all();
        }
        if ($UsersForm['rol'] == 'ADMIN') {
            return self::find()->select(['id', 'name'])->where(['id' => $UsersForm['data']])->asArray()->all();
        }
    }

    public static function GetEmailDataById($id)
    {
        if (!empty($id)) {
            return self::findOne(['id' => $id]);
        }
        return null;
    }
}
