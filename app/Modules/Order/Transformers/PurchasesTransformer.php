<?php namespace App\Modules\Order\Transformers;


use App\Transformers\Transformer;

class PurchasesTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'id'          => $item->pivot->product_id,
            'thumbnail'   => $item->media[0]->src,
            'slug'        => $item->slug,
            'price'       => $item->price,
            'title'       => $item->title,
            'order'       => $item->pivot->order_id,
            'date'        => $item->pivot->created_at ? $item->pivot->created_at->diffForHumans() : 'date'
        ];


    }
}