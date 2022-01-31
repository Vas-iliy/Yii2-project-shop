<?php


namespace frontend\services\auth;


use common\models\User;
use frontend\forms\SignupForm;

class SignupService
{
    public function signup(SignupForm $form): User
    {
        if (User::find()->andWhere(['username' => $form->username])) {
            throw new \DomainException('Username is already exists.');
        }
        if (User::find()->andWhere(['email' => $form->email])) {
            throw new \DomainException('E-mail is already exists.');
        }
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