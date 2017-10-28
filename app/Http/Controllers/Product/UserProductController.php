<?php namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Modules\Product\Commands\GetSellerProductsCommand;
use App\Modules\Product\Transformers\ProductTransformer;
use Illuminate\Http\Request;

class UserProductController extends ApiController
{
    /**
     * @var ProductTransformer
     */
    private $transformer;

    /**
     * UserProductController constructor.
     * @param ProductTransformer $transformer
     */
    public function __construct(ProductTransformer $transformer)
    {

        $this->transformer = $transformer;
    }

    /**
     * @param $username
     * @return mixed
     */
    public function index($username)
    {
        $products = $this->dispatchNow(new GetSellerProductsCommand($username));

        if(! $products){
            return $this->NotFound('No records found!');
        }

        return $this->respond([
            'data' => $this->transformer->transformCollection($products),
            'page_info' => [
                'has_more' => $products->hasMorePages()
            ]
        ]);
    }
}
