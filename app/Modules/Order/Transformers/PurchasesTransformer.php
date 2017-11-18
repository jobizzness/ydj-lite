<?php namespace App\Modules\Order\Transformers;


use App\Transformers\Transformer;

class PurchasesTransformer extends Transformer
{

    public function transform($item)
    {
        return [
            'id'          => $item->id,
            'thumbnail'   => $item->media[0]->src,
            'slug'        => $item->slug,
            'price'       => $item->price,
            'title'       => $item->title,
            'date'        => $item->pivot->created_at->diffForHumans()
        ];


    }
}