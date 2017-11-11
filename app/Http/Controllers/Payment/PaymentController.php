<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\ApiController;
use App\Modules\Order\Models\OrderProduct;
use Braintree_ClientToken;
use Braintree_Configuration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends ApiController
{


    public function __construct()
    {
        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('8w9tfzgrcjzxsxtv');
        Braintree_Configuration::publicKey('ssbz9zjpx5fkbsnr');
        Braintree_Configuration::privateKey('5ed2b4326ba3bc0617aeb0b85e83c6bf');

    }

    public function generateKey()
    {
        return $this->respond(Braintree_ClientToken::generate());
    }
    /**
     * The user wants to buy something.
     * Lets take a look.
     *
     * @return mixed
     */
    public function checkout()
    {

        $user = request()->user();
        $products = $user->cart();
        $total = 0;

        foreach ($products as $item){
            if(!$item['price']) continue;
            $total += $item['price'];
        }

        $order = $user->orders()->create([
            'total'     => $total,
            'is_paid'   => false,

        ]);

        $this->addOrderItems($products, $order);


    }

    public function cancel()
    {

    }

    private function addOrderItems($products, $order)
    {
        foreach ($products as $item){
            OrderProduct::create([
                'order_id'      => $order->id,
                'product_id'    => $item['id'],
                'seller_id'     => $item['user_id']
            ]);
        }
    }
}
