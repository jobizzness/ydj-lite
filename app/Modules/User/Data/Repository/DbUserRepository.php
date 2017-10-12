<?php namespace App\Modules\User\Data\Repository;

use App\Modules\User\Models\User;

class DbUserRepository implements UserRepositoryInterface
{

    public function create(array $data): User
    {
        return User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $data['password'],
            "balance_id" => null,

        ]);
    }
}