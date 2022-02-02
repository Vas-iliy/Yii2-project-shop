<?php

namespace shop\services\auth;

use shop\repositories\UserRepository;
use shop\forms\auth\ResendVerificationEmailForm;
use Yii;

class ResendVerificationEmailService
{
    private $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function sendEmail(ResendVerificationEmailForm $form)
    {
        $user = $this->users->getBy(['email' => $form->email]);
        $send = Yii::$app->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($form->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
        if (!$send) {
            throw new \DomainException('No E-mail');
        }
        return $send;
    }
}