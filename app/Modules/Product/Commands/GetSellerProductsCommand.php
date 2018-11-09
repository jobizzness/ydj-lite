<?php namespace App\Modules\Product\Commands;

use App\Modules\Product\Repository\ProductRepositoryInterface;
use Illuminate\Console\Command;

class GetSellerProductsCommand extends Command
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
     * @var mixed
     */
    protected $products;
    /**
     * @var
     */
    private $username;

    /**
     * Create a new command instance.
     *
     * @param $username
     */
    public function __construct($username)
    {
        parent::__construct();
        $this->products = resolve(ProductRepositoryInterface::class);
        $this->username = $username;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->username == 'self' ?
            request()->user()->id :
            0;
        //TODO maybe we should get they userbyusername

        return $this->products->byUser($id)->paginate(10);
    }
}
