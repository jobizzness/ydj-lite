<?php namespace App\Modules\Product\Repository;

interface ProductRepositoryInterface
{
    public function create($title, $description, $user_id, $price, $slug, $category, $is_free, Array $media, $asset_url);

    public function byUser($id);

    public function findBySlug($identifier);
}