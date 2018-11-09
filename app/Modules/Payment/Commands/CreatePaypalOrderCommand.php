<?php

namespace App\Modules\Payment\Commands;
use App\Modules\Order\Models\Order;
use App\Modules\Payment\Models\Payment;
use Paypal;
use Illuminate\Console\Command;

class CreatePaypalOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var
     */
    public $order;
    /**
     * @var
     */
    public $items;
    protected $paypalService;

    /**
     * Create a new command instance.
     *
     * @param $order
     * @param $items
     */
    public function __construct($order, $items)
    {
        parent::__construct();
        $this->order = $order;
        $this->items = $items;
        $this->paypalService = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret')
        );

        // PayPal configurations
        $this->paypalService->setConfig(config('paypal_payment'));


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $itemList = PayPal::ItemList();
        $itemList->setItems($this->convertToPaypalItems($this->items));

        $amount = PayPal::Amount();
        $amount->setCurrency('USD')->setTotal($this->order->total);


        $transaction = PayPal::Transaction();
        $transaction->setItemList($itemList);
        $transaction->setAmount($amount);
        $transaction->setDescription('Thank you for using YDJ.');

        $redirectUrls = PayPal::RedirectUrls();
        $redirectUrls->setReturnUrl( route('getDone', $this->order->id) );
        $redirectUrls->setCancelUrl( route('getCancel', $this->order->id ) );

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));


        $response = $payment->create($this->paypalService);


        return $response;
    }

    private function convertToPaypalItems($products)
    {
        return array_map(function($item){
            return PayPal::Item()
                ->setQuantity(1)
                ->setName($item['description'])
                ->setPrice($item['price'])
                ->setCurrency('USD');
        }, $products->toArray());
    }
}
