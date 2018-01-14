<?php namespace App\Modules\Product\Tasks;

use App\Modules\Product\Repository\ProductRepositoryInterface;
use App\Modules\User\Data\Repository\UserRepositoryInterface;
use Illuminate\Console\Command;

class GetProductTask extends Command
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
    private $identifier;

    /**
     * Create a new command instance.
     * @param $identifier
     */
    public function __construct($identifier)
    {
        parent::__construct();
        $this->products = resolve(ProductRepositoryInterface::class);
        $this->identifier = $identifier;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!$this->identifier) return;

        if(is_numeric($this->identifier)){
            //return $this->products->findById($this->identifier);
        }
        return $this->products->findBySlug($this->identifier)
                ->with('media')->first();
    }
}
