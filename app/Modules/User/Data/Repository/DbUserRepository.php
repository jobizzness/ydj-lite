<?php namespace App\Modules\User\Data\Repository;

use App\Modules\User\Models\User;

class DbUserRepository implements UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $data['password'],
            "balance_id" => null,

        ]);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function findByNickname($name)
    {
        return User::whereNickname($name)->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id){

        return User::find($id);
    }

}