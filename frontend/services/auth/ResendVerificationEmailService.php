<?php

namespace frontend\services\auth;

use common\models\User;
use frontend\forms\ResendVerificationEmailForm;
use Yii;

class ResendVerificationEmailService
{
    public function sendEmail(ResendVerificationEmailForm $form)
    {
        if (!User::find()->andWhere(['status' => User::STATUS_INACTIVE])->one()) {
            throw new \DomainException('There is no user with this email address.');
        }
        $user = User::findOne([
            'email' => $form->email,
            'status' => User::STATUS_INACTIVE
        ]);
        if ($user === null) {
            throw new \DomainException('User not exist.');
        }
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