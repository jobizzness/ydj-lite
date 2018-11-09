<?php namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Modules\Order\Commands\GetBuyerPurchasesCommand;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Transformers\PurchasesTransformer;
use App\Modules\Product\Commands\GetSellerProductsCommand;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Transformers\ProductTransformer;
use DateTime;
use Illuminate\Http\Request;
use Spatie\UrlSigner\MD5UrlSigner;

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

    /**
     * @param PurchasesTransformer $transformer
     * @return mixed
     */
    public function purchases(PurchasesTransformer $transformer)
    {

        $products = $this->dispatchNow(new GetBuyerPurchasesCommand(request()->user()));

        if(! $products){
            return $this->NotFound('No records found!');
        }

        return $this->respond([
            'data' => $transformer->transformCollection($products),
            'page_info' => [
                'has_more' => false
            ]
        ]);
    }

    /**
     * @return bool
     */
    public function userCanDownloadProduct()
    {
        return $this->order->is_paid && ($this->order->user_id === request()->user()->id)
            && $this->orderItem;
    }

    /**
     * @param Request $request
     * @return string|void
     */
    public function getPurchasedItem(Request $request)
    {
        $this->order = Order::find($request->order);
        $this->product = Product::find($request->product);

        $this->orderItem = $this->order->products()->find($request->product);

        if(!$this->userCanDownloadProduct()){
            return  'fraud';
        }

        return $this->makeDownloadLink();
    }

    /**
     * @return mixed
     */
    private function makeDownloadLink()
    {
        $urlSigner = new MD5UrlSigner(env('APP_KEY'));

        $expirationDate = (new DateTime)->modify('10 days');

        $downloadLink = $urlSigner->sign(env('APP_URL') . '/purchases/download/' . $this->orderItem->id, $expirationDate);

        return $this->respond($downloadLink);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function download(Request $request, $id)
    {
        $product = Product::find($id);

        if(!$product)  return  'oops sorry!';

        $urlSigner = new MD5UrlSigner(env('APP_KEY'));

        if(!$urlSigner->validate($request->fullUrl())) return  'fraud';

        return redirect()->to($product->asset);
    }
}
