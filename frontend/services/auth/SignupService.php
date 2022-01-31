<?php

namespace frontend\services\auth;

use common\models\User;
use common\repositories\UserRepository;
use frontend\forms\SignupForm;
use Yii;

class SignupService
{
    private $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }
    public function signup(SignupForm $form): User
    {
        $this->users->condition(['username' => $form->username]);
        $this->users->condition(['email' => $form->email]);
        $user = $this->users->save(User::signup($form->username, $form->email, $form->password));
        $this->sendEmail($user, $form);
        return $user;
    }

    public function sendEmail(User $user, SignupForm $form)
    {
        $send = Yii::$app->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($form->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
        if (!$send) {
            throw new \RuntimeException('None');
        }
    }
}