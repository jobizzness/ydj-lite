<?php namespace App\Modules\Repository;

interface MediaRepositoryInterface
{
    public function store($file, $name);
}