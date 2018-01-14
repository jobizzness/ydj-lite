<?php namespace App\Modules\Product\Transformers;

use App\Transformers\Transformer;

class CartTransformer extends Transformer
{
    public function transform($items)
    {
        $response = [
            'total'     => money_format ('%i', 0 ),
            'items'     => [],
            'empty'     => $items->isEmpty()
        ];

        $response['items'] = $items->transform(function ($item, $key){
            return [
                'id'          => $item->id,
                'thumbnail'   => $item->media[0]->src,
                'slug'        => $item->slug,
                'price'       => $item->price,
                'title'       => $item->title
            ];
        });

        if(!$items->isEmpty()) {
            $total = 0;

            foreach ($items as $item){
                if(!$item['price']) continue;
                $total += $item['price'];
            }

            $response['total'] = money_format ('%i', $total );
        }
        return $response;
    }
}