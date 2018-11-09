<?php

namespace App\Modules\Product\Commands;

use App\Cart;
use App\Modules\Product\Tasks\GetProductTask;
use Illuminate\Console\Command;

class RemoveFromCartCommand extends Command
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
     * Create a new command instance.
     *
     * @param $slug
     */
    public function __construct($slug)
    {
        parent::__construct();

        $this->product = dispatch_now(new GetProductTask($slug));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(!$this->product) return;

        Cart::where('user_id', request()->user()->id)
            ->where('item_id', $this->product->id)->delete();


        return true;
    }
}
