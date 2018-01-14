<?php namespace App\Modules\User\Transformers;
use App\Modules\Product\Transformers\CartTransformer;
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
            'balance'              => money_format ('%i', $user->balance),
            'purchases'            => [],
            'cart'                 => $this->getCart($user),
            'billing'              => $user->billing

        ];

        $response = $this->ifAdmin([
            'is_admin' => $user->hasRole('admin')
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

        return (new CartTransformer())->transform($items);

    }

}