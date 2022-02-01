<?php

namespace shop\services\auth;

use shop\entities\user\User;
use shop\repositories\UserRepository;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use Yii;

class PasswordResetService
{
    private $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }
    public function request(PasswordResetRequestForm $form)
    {
        $user = $this->users->getBy(['email' => $form->email]);
        $user->requestPasswordReset();
        $this->users->save($user);
        $sent = \Yii::$app->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        if (!$sent) throw new \RuntimeException('Sending error.');
    }

    public function validateToken($token)
    {
        if (empty($token) || !is_string($token)) throw new \DomainException('Password reset token cannot be blank');
        $this->users->getUser(User::findByPasswordResetToken($token));
    }

    public function reset($token, ResetPasswordForm $form)
    {
        $user = $this->users->getUser(User::findByPasswordResetToken($token));
        $user->resetPassword($form->password);
        $this->users->save($user);
    }
}