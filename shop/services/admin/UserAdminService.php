<?php

namespace shop\services\admin;

use shop\entities\user\User;
use shop\forms\admin\UserUpdateForm;
use shop\forms\auth\SignupForm;
use shop\repositories\UserRepository;

class UserAdminService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function create(SignupForm $form)
    {
        $this->repository->condition(['username' => $form->username]);
        $this->repository->condition(['email' => $form->email]);
        $user = User::signup($form->username, $form->email, $form->password);
        $user->status = User::STATUS_ACTIVE;
        $this->repository->save($user);
        return $user;
    }

    public function edit($id, UserUpdateForm $form)
    {
        $user = $this->repository->getBy(['id' => $id]);
        $user->edit($form->username, $form->email);
        $this->repository->save($user);
    }

    public function delete($id)
    {
        $user = $this->repository->getBy(['id' => $id]);
        $user->status = User::STATUS_DELETED;
        $this->repository->save($user);
    }
}