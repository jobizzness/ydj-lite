<?php namespace App\Modules\Order\Commands;

use Illuminate\Console\Command;

class GetBuyerPurchasesCommand extends Command
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
    private $buyer;

    /**
     * Create a new command instance.
     *
     * @param $buyer
     */
    public function __construct($buyer)
    {
        parent::__construct();
        $this->buyer = $buyer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $purchases = $this->buyer->purchases()->with('products')
            ->orderBy('created_at')
            ->get();

        return $this->extractProducts($purchases);
    }

    /**
     * @param $purchases
     * @return array
     */
    private function extractProducts($purchases)
    {
        $collection = [];
        foreach ($purchases as $purchase){
            foreach ($purchase->products as $product){
                $collection[] = $product;
            }
        }

        return collect($collection);
    }
}
