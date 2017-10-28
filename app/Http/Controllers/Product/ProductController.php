<?php namespace App\Http\Controllers\Product;

use App\Modules\Product\Commands\CreateNewProductCommand;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Requests\CreateProductRequest;
use App\Modules\Product\Transformers\ProductTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
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

    public function index()
    {
        $products = Product::with('media', 'owner')->orderBy('created_at')->paginate(10);

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



    /**
     * Create a new product
     *
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->dispatchNow(new CreateNewProductCommand($request));

        if(! $product){
            return $this->requestFailed('Opps! There was an error creating the product');
        }

        return $this->respond($this->transformer->transform($product));
    }

    public function show()
    {

    }
}
