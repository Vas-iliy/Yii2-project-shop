<?php

namespace shop\services\auth;

use shop\entities\User;
use shop\forms\auth\LoginForm;
use shop\repositories\UserRepository;
use shop\forms\auth\SignupForm;
use Yii;

class AuthService
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

    public function auth(LoginForm $form)
    {
        $user = $this->users->getBy(['username' => $form->username]);
        if (!$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined password');
        }
        return $user;
    }
}