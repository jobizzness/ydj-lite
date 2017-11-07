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
            "nickname"          => $data['nickname'],
            "name"              => $data['nickname'],
            "email"             => $data['email'],
            "password"          => $data['password'],
            "balance_id"        => null,
            "avatar"            => $data['avatar'] ?: ''

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


    public function findByEmailOrCreate($data)
    {
        $user = User::where('email', $data->email)
            ->first();
        if(!$user){
            $user = $this->create ([
                "nickname"          => $data->nickname ?:  rand(5, 15),
                "name"              => $data->name,
                "email"             => $data->email,
                "password"          => null,
                "balance_id"        => null,
                "avatar"            => $data->avatar
            ]);
        }
        return $user;

    }
}