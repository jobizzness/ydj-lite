<?php namespace App\Modules\Payment\Commands;

use App\Modules\Order\Models\Order;
use App\Modules\Order\Tasks\CompleteOrderTask;
use App\Modules\Payment\Models\Payment;
use App\Modules\User\Models\User;
use Paypal;
use Illuminate\Console\Command;

class VerifyPaypalTransactionCommand extends Command
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
    protected $_apiContext;
    /**
     * @var
     */
    private $order;

    /**
     * Create a new command instance.
     * @param $order
     */
    public function __construct($order)
    {
        parent::__construct();

        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret')
        );

        $this->_apiContext->setConfig(config('paypal_payment'));

        $this->order = $order;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $payment = $this->executePaypalPayment();

        //get sale array from paypal
        $transaction = $payment->getTransactions();
        $resources = $transaction[0]->getRelatedResources();
        $sale = $resources[0]->getSale();


        $this->completeOrder()
        ->clearCart()
        ->storePaymentInformation($sale);

    }

    /**
     * @return $this
     */
    private function completeOrder()
    {
        dispatch_now(new CompleteOrderTask($this->order));
        return $this;
    }

    /**
     * @return $this
     */
    private function clearCart()
    {
        $user = User::find($this->order->user_id)->first();
        $user->clearCart();

        return $this;
    }

    /**
     * @param $sale
     * @return $this
     */
    private function storePaymentInformation($sale)
    {
        Payment::create([
                'order_id'          => $this->order->id,
                'transaction_id'    => $sale->getId(),
                'amount'            => $sale->getAmount()->getTotal(),
                'currency'          => $sale->getAmount()->currency
        ]);

        return $this;
    }

    /**
     * @return mixed
     */
    private function executePaypalPayment()
    {
        $paymentExecution = PayPal::PaymentExecution();

        $payment = PayPal::getById(request()->get('paymentId'), $this->_apiContext);
        $paymentExecution->setPayerId(request()->get('PayerID'));

        $payment->execute($paymentExecution, $this->_apiContext);

        return $payment;
    }
}
