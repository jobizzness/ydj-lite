<?php namespace App\Modules\User\Transformers;
use App\Transformers\Transformer;

class UserTransformer extends Transformer
{
    public function transform($user)
    {

        $response = [
            'id'                   => $user->id,
            'name'                 => $user->name,
            'nickname'             => $user->nickname,
            'gender'               => $user->gender,
            'birth'                => $user->birth,
            'email'                => $user->email,
            'bio'                  => $user->bio,
            'location'             => $user->location,
            'highlight'            => "something.jpg",
            'is_seller'            => (boolean) $user->is_seller,
            'avatar'               => $user->present()->currentAvatar,
            'created_at'           => $user->created_at->diffForHumans(),
            'updated_at'           => $user->updated_at->diffForHumans(),
            'balance'              => money_format ('%i', 0 ),
            'purchases'            => [],
            'cart'                 => $this->getCart($user)

        ];

        $response = $this->ifAdmin([

        ], $response);

        $response = $this->sellerResponse([
            'products' => [],
            'orders'    => [],

        ], $response);

        return $response;
    }

    /**
     * @param $user
     * @return array
     */
    private function getCart($user)
    {
        $items = $user->cart();

        $response = [
            'total'     => 100,
            'items'     => [],
            'empty'     => false
        ];

        $response['items'] = $items->transform(function ($item, $key){
            return [
              'id'          => $item->id,
              'thumbnail'   => '',
              'slug'        => $item->slug,
              'price'       => $item->price
            ];
        });

        return $response;

    }

}