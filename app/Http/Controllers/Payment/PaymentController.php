<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\ApiController;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderProduct;
use App\Modules\Payment\Commands\CreatePaypalOrderCommand;

class PaymentController extends ApiController
{

    /**
     * The user wants to buy something.
     * Lets take a look.
     *
     * @return mixed
     */
    public function checkout()
    {

        $user = request()->user();
        $items = $user->cart();
        $total = 0;

        foreach ($items as $item){
            if(!$item['price']) continue;
            $total += $item['price'];
        }

        $order = $user->orders()->create([
            'total'     => $total,
            'is_paid'   => false,
        ]);

        $this->addOrderItems($items, $order);

        $response =  $this->dispatchNow(new CreatePaypalOrderCommand($order, $items));

        if (! $response->links[1]) {
            return $this->requestFailed('There was an error with the transaction');
        }

        return $this->respond([
            'response' => [
                'redirect_link' => $response->links[1]->href,
            ]
        ]);


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


    /**
     *  Verify PayPal Transaction.
     *
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyPaypalTransaction($order, Request $request)
    {

        $this->dispatch(new VerifyPaypalTransaction($order));

        //balance the user
        foreach($order->products as $item)
        {
            //User::saleCompleted($item);
        }

        return redirect('https://design.jobizzness.com/payment/success');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getCancel()
    {
        //delete linked order attempt to prevent spam in the database

        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        return redirect('http://afrodapp.com/cart');
    }
}
