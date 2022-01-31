<?php


namespace shop\services\auth;


use shop\forms\auth\LoginForm;
use shop\entities\User;
use shop\repositories\UserRepository;

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