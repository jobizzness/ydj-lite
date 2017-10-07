<?php namespace App\Transformers;

abstract class Transformer
{
    public abstract function transform($item);

    /**
     * Transforms a collection using the transform method the the child class.
     *
     * @param $items
     * @return
     */
    public function TransformCollection($items)
    {
        return $items->transform(function ($item){
            return $this->transform($item);
        });
    }
}