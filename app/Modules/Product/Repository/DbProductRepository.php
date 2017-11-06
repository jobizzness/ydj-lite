<?php namespace App\Modules\Product\Repository;

use App\Modules\Category\Models\Category;
use App\Modules\Media\Models\Media;
use App\Modules\Product\Models\Product;

class DbProductRepository implements ProductRepositoryInterface
{
    public function create($title, $description, $user_id, $price, $slug, Array $categories, $is_free, Array $media, $asset_url)
    {
        $product = new Product();
        $product->title = $title;
        $product->description = $description;
        $product->user_id = $user_id;
        $product->price = $price;
        $product->slug = $slug;
        $product->is_free = $is_free;
        $product->asset = $asset_url;
        $product->save();

        //Attach Media
        foreach($media as $id){
            $item = Media::find($id);

            if($item){
                $item->product_id = $product->id;
                $item->save();
            }
        }

        // Attach Categories
        $this->attachCategories($categories, $product);

        return $product;
    }

    /**
     * Generates Unique Slug
     *
     * @param $title
     * @return mixed
     */
    public function generateSlug($title)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $title);

        $slugExists = Product::where('slug', $slug)->first();

        if($slugExists){
            return $this->generateSlug($slug.substr(md5(mt_rand()), 0, 4));
        }

        return $slug;
    }

    public function byUser($id)
    {
        return Product::with('owner','media')
            ->where('user_id', $id)
            ->orderByDesc('created_at');
    }

    public function findBySlug($identifier)
    {
        return Product::whereSlug($identifier);
    }


    private function attachCategories($categories, $product)
    {
//        TODO needs attention
        $product->categories()->sync([Category::whereSlug($categories[0])->first()->id]);
    }
}