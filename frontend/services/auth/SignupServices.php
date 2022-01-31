<?php


namespace frontend\services\auth;


use common\models\User;
use frontend\forms\SignupForm;

class SignupServices
{
    public function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);
        if (!$user->save()) throw new \RuntimeException('Saving error.');
        $this->sendEmail($user, $form);
        return $user;
    }

    public function sendEmail(User $user, SignupForm $form)
    {
        return \Yii::$app->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($form->email)
            ->setSubject('Account registration at ' . \Yii::$app->name)
            ->send();
    }
}