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
            'social_id'            => $user->social_id,
            'bio'                  => $user->bio,
            'highlight'            => "something.jpg",
            'is_seller'            => (boolean) $user->is_seller,
            'avatar'               => $user->present()->avatar,
            'created_at'           => $user->created_at->diffForHumans(),
            'updated_at'           => $user->updated_at->diffForHumans(),
            'balance'              => money_format ('%i', 0 ),

        ];

        $response = $this->ifAdmin([

        ], $response);

        return $response;
    }

    /**
     * Return sensitive data if admin
     * @param $adminResponse
     * @param $clientResponse
     * @return array
     */
    public function ifAdmin($adminResponse, $clientResponse)
    {
        $user = $this->user();
        if (!is_null($user) && $user->hasRole('admin')) {
            return array_merge($clientResponse, $adminResponse);
        }
        return $clientResponse;
    }

    /**
     * Get the current user
     */
    private function user()
    {
        return request()->user();
    }
}