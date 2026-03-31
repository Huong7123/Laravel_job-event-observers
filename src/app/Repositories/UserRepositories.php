<?php

namespace App\Repositories;

use App\Models\User;

class UserRepositories
{
    public function getAllUser()
    {
        return User::all();
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();
        return $user;
    }
}
