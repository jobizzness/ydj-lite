<?php namespace App\Http\Controllers\Product;

use App\Console\Commands\ChangProductStatusCommand;
use App\Modules\Product\Commands\AddToCartCommand;
use App\Modules\Product\Commands\CreateNewProductCommand;
use App\Modules\Product\Commands\RemoveFromCartCommand;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Requests\CreateProductRequest;
use App\Modules\Product\Tasks\GetProductTask;
use App\Modules\Product\Transformers\CartTransformer;
use App\Modules\Product\Transformers\ProductTransformer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

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
        $products = Product::with('media', 'owner')
                            ->orderBy('created_at')
                            ->where('status', Product::STATUS['approve'])
                            ->paginate(10);

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

    public function productRequests()
    {
        $products = Product::with('media', 'owner')
            ->orderBy('created_at')
            ->where('status',  Product::STATUS['publish'])
            ->paginate(10);

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

    public function show($id)
    {
        $product = Product::whereSlug($id)
        ->with('owner', 'media', 'categories')->first();

        if(! $product){
            return $this->requestFailed('Opps! There was an error getting the product');
        }

        return $this->respond($this->transformer->transform($product));
    }

    public function update($id)
    {
        $product = Product::whereSlug($id)->first();

        if(request()->user()->id == $product->user_id){

            $updated = $product->fill(request()->all())->save();

            if(! $updated){
                return $this->respond([
                    'data' => [
                        'message' => 'Opps! There was an updating the product'
                    ]
                ], 503);
            }

            return $this->respond($this->transformer->transform($product));
        }
    }

    /**
     * Attach new cart item to the store
     * or update and existing item
     * @param $slug
     * @return mixed
     */
    public function cartStore($slug)
    {

        $updatedCart = $this->dispatchNow(new AddToCartCommand($slug));

        if(! $updatedCart){
            return $this->respond([
                'data' => [
                    'message' => 'Opps! There was an adding the product'
                ]
            ], 503);
        }

        return $this->respond((new CartTransformer())->transform(request()->user()->cart()));

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function cartDestroy($slug)
    {
        $updatedCart = $this->dispatchNow(new RemoveFromCartCommand($slug));

        if(! $updatedCart){
            return $this->respond([
                'data' => [
                    'message' => 'Opps! There was an adding the product'
                ]
            ], 503);
        }

        return $this->respond((new CartTransformer())->transform(request()->user()->cart()));
    }

    /**
     * Favorite a particular post
     *
     * @param $slug
     * @return Response
     */
    public function favoriteProduct($slug)
    {
        $product = $this->dispatchNow(new GetProductTask($slug));

        if($product){
            $product->like();
            return $this->respond(true);
        }
        return $this->respondWithError(false);
    }

    /**
     * Unfavorite a particular post
     *
     * @param $slug
     * @return Response
     */
    public function unFavoriteProduct($slug)
    {
        $product = $this->dispatchNow(new GetProductTask($slug));

        if($product){
            $product->unlike();
            return $this->respond(true);
        }
        return $this->respondWithError(false);
    }

    public function favorites()
    {
        $products = Product::whereLikedBy(request()->user()->id)
            ->with('media', 'owner')
            ->orderBy('created_at')
            ->where('status', Product::STATUS['approve'])
            ->paginate(10);

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
     * @param $command
     * @return mixed
     */
    public function changeStatus($command)
    {
        $changed = $this->dispatchNow(new ChangProductStatusCommand());

        if($changed){
            return $this->respond(true);
        }
        return $this->respondWithError(false);
    }
}
