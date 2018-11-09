<?php namespace App\Transformers;

abstract class Transformer
{
    public abstract function transform($item);

    /**
     * Transforms a collection using the transform method the the child class.
     *
     * @param $items
     * @return array
     */
    public function TransformCollection($items)
    {
        return $items->transform(function ($item){
            return $this->transform($item);
        });
    }

    /**
     * Return sensitive data if admin
     * @param $adminResponse
     * @param $clientResponse
     * @return array
     */
    protected function ifAdmin($adminResponse, $clientResponse)
    {
        $user = $this->user();
        if (!is_null($user) && $user->hasRole('admin')) {
            return array_merge($clientResponse, $adminResponse);
        }
        return $clientResponse;
    }

    /**
     * Current User
     * @return mixed
     */
    protected function user()
    {
        return request()->user();
    }

    /**
     * @param $sellerResponse
     * @param $response
     * @param $product
     * @return array
     */
    protected function ownerOrAdmin($sellerResponse, $response, $product)
    {
        $user = $this->user();
        if(!is_null($user) && ($user->isAdmin() || $user->id === $product->user_id)){
            return array_merge($sellerResponse, $response);
        }
        return $response;
    }

    public function sellerResponse($sellerResponse, $response)
    {
        $user = $this->user();
        if(!is_null($user) && $user->is_seller){
            return array_merge($sellerResponse, $response);
        }
        return $response;
    }
}