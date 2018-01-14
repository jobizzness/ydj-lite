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
     * @return array
     */
    protected function sellerResponse($sellerResponse, $response)
    {
        $user = $this->user();
        if(!is_null($user) && $user->is_seller){
            return array_merge($sellerResponse, $response);
        }
        return $response;
    }
}