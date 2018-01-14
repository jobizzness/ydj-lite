<?php namespace App\Modules\User\Data\Repository;


interface UserRepositoryInterface
{

    public function create(array $data);

    public function findByNickname($name);

    public function findById($identifier);
}