<?php namespace App\Modules\Product\Commands;

use App\Modules\Product\Repository\ProductRepositoryInterface;
use Illuminate\Console\Command;

class CreateNewProductCommand extends Command
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
    protected $title;

    /**
     * @var
     */
    protected $user_id;

    /**
     * @var string
     */
    protected $categories;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var
     */
    private $products;

    /**
     * @var
     */
    protected $price;

    /**
     * @var Array
     */
    protected $media;

    protected $desc;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        parent::__construct();

        $this->products = resolve(ProductRepositoryInterface::class);
        $this->title = $data->title;
        $this->desc = $data->description;
        $this->user_id = $data->user()->id;
        $this->categories = $data->categories ?: [];
        $this->price = $data->price;
        $this->slug = $this->products->generateSlug($this->title);
        $this->media = $data->media_list ?: []; // [] Array
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->products->create(
            $this->title,
            $this->desc,
            $this->user_id,
            $this->price,
            $this->slug,
            $this->categories,
            $this->media
        );
    }
}
