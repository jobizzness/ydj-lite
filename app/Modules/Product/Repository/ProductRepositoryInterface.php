<?php namespace App\Modules\Product\Repository;

interface ProductRepositoryInterface
{
    public function create($title, $description, $user_id, $price, $slug, Array $category, Array $media);
}