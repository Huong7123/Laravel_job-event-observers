<?php

namespace App\Services;

use App\Repositories\UserRepositories;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositories $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUser();
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepository->updateUser($id, $data);
    }
}