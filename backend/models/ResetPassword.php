<?php
namespace backend\models;

use common\models\User;
use common\models\UsersForms;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ResetPassword extends Model
{
    public $password;
    public $confirm_password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
        ];
    }

    public function Reset()
    {
        $user = new User();
        if ($this->password === $this->confirm_password) {
            return $user->SaveNewPassword($this->password);
        }
        return false;
    }


}
