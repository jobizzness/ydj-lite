<?php namespace App\Modules\Payment\Commands;

use App\Modules\Order\Models\Order;
use App\Modules\Payment\Models\Payment;
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
        $id = request()->get('paymentId');
        $token = request()->get('token');
        $payer_id = request()->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        //get shipping address

        $payerInfo = $payment->getPayer()->getPayerInfo();


        //get sale array from paypal
        $transaction = $payment->getTransactions();
        $resources = $transaction[0]->getRelatedResources();
        $sale = $resources[0]->getSale();


        //transaction id
        $transaction_id = $sale->getId();

        //amount buyer paid
        $amount = $sale->getAmount()->getTotal();

        //currency
        $currency = $sale->getAmount()->currency;

        $order_id = $this->order->id;

        //add payment into payment table
        $payment = Payment::create(compact('order_id', 'transaction_id', 'amount', 'currency'));

        //mark order as paid
        $this->order->is_paid = true;
        $this->order->save();

        //mark all items as paid
        //Order::setPaid($this->order->id);

    }
}
