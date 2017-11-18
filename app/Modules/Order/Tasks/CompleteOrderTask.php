<?php namespace App\Modules\Order\Tasks;

use App\Modules\Payment\Models\Payment;
use App\Sale;
use Illuminate\Console\Command;

class CompleteOrderTask extends Command
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
    private $order;

    /**
     * Create a new command instance.
     *
     * @param $order
     */
    public function __construct($order)
    {
        parent::__construct();
        $this->order = $order;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->order->is_paid = true;
        $this->order->save();
        $this->createNewSale();
    }


    /**
     *
     */
    public function createNewSale()
    {
        foreach ($this->order->products as $product){
            Sale::create([
               'seller'         => $product->user_id,
               'buyer'          => $this->order->user_id,
               'product'        => $product->id,
               'product_title' => $product->title
            ]);

            $this->updateSellersBalance($product);
        }

    }

    /**
     * @param $product
     */
    private function updateSellersBalance($product)
    {
        $amount = Payment::chargeFees($product->price);
        $product->owner->addAmount($amount);

    }
}
