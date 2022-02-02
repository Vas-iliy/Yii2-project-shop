<?php

namespace shop\services\auth;

use shop\entities\user\User;
use yii\base\InvalidArgumentException;

class VerifyEmailService
{
    public function verifyEmail($token)
    {
        if (empty($token) || !is_string($token)) throw new InvalidArgumentException('Verify email token cannot be blank.');
        if (!$user = User::findByVerificationToken($token)) throw new InvalidArgumentException('Wrong verify email token.');
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }
}