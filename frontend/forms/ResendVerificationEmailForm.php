<?php

namespace frontend\forms;

use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }
}
