<?php namespace App\Modules\Product\Transformers;

use App\Transformers\Transformer;

class ProductTransformer extends Transformer
{

    /**
     * The public param tells not to send in any sensitive data.
     *
     * @param $product
     * @return array
     * @internal param bool|true $public
     */
    public function transform($product)
    {
        $response = [
            'id'                => $product->id,
            'title'             => $product->title,
            'excerpt'           =>  $product->present()->excerpt,
            'description'       => $product->present()->descriptionWithLinks,
            'alt'               => $product->description,
            'price'             => $product->price ? number_format((float) $product->price, 2) : null,
            'slug'              => $product->slug,
            'published_at'      => $product->created_at->diffForHumans(),
            'category'          => $product->category_id,
            'owner'             => $this->getOwner($product),
            'media'             => $this->getMedia($product),
            'media_list'        => $this->listMedia($product),
            'is_free'           => (boolean) $product->is_free,
            'extensions'        => $product->extensions,
            'size'              => '1.0 MB',
            'status'            => $product->status,
            'views'             => $product->views,
            'likes'             => $this->getLikes($product)

        ];

        $response = $this->ifAdmin([

        ], $response);


        $response = $this->sellerResponse([
            'asset' => $product->asset

        ], $response);

        return $response;
    }


    /**
     * @param $product
     * @return array
     */
    private function getOwner($product)
    {
        return [
            'name'          => $product->owner->name,
            'avatar'        => $product->owner->present()->currentAvatar,
            'nickname'      => $product->owner->nickname,
            'company'       => $product->owner->company

        ];
    }

    /**
     * @param $product
     * @return array
     */
    private function getMedia($product){
        $media = [];

        foreach($product->media as $item){
            $media[] = [
                'id' => $item->id,
                'src' => $item->src,
                'media_type' => $item->media_type
            ];
        }

        return $media;
    }

    private function getCategories($product)
    {
        $category = $product->categories;

        if($category) return $category->slug;
    }

    private function listMedia($product)
    {
        $images = [];

        foreach ($product->media as $item) {
            array_push($images, $item->id);
        }

        return $images;

    }

    private function getLikes($product)
    {
        return [
            'count'             => $product->likeCount,
            'is_liked'          => $product->liked()
        ];
    }
}