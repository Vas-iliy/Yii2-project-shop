<?php


namespace common\services;


use common\forms\LoginForm;
use common\models\User;
use common\repositories\UserRepository;

class LoginService
{
    private $users;
    public function __construct()
    {
        $this->users = new UserRepository;
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