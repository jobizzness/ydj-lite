<?php namespace App\Modules\User\Transformers;

use App\Transformers\Transformer;

class ProfileTransformer extends Transformer
{
    public function transform($user)
    {

        $response = [
            'id'                   => $user->id,
            'name'                 => $user->name,
            'nickname'             => $user->nickname,
            'bio'                  => $user->bio,
            'highlight'            => $user->highlight,
            'location'             => $user->location,
            'is_seller'            => (boolean) $user->is_seller,
            'avatar'               => $user->present()->avatar,
            'created_at'           => $user->created_at->diffForHumans(),
            'updated_at'           => $user->updated_at->diffForHumans(),

        ];

        return $response;
    }
}