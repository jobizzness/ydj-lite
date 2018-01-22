<?php

namespace App\Console\Commands;

use App\Events\ItemApproved;
use App\Mail\ItemRejected;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Tasks\GetProductTask;
use Illuminate\Console\Command;

class ChangProductStatusCommand extends Command
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
     */
    public function __construct()
    {
        parent::__construct();
        $this->command = request()->command;
    $this->data = request()->all();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if(!Product::STATUS[$this->command]) return false;

        switch ($this->command){
            case 'publish':
                return $this->publish();
            case 'approve':
            case 'reject':
                return $this->rejectOrApprove($this->command);
        }

        return false;
    }

    private function publish()
    {
        // if the post is not a draft then ignore this shitt
        $product = dispatch_now(new GetProductTask($this->data['slug']));
        if(!$product) return false;

        if($product->status != Product::STATUS['approve']){
            $product->status = Product::STATUS['publish'];
            $product->save();
        }
        return true;
    }

    private function rejectOrApprove($command)
    {
        if(!request()->user()->hasRole('admin')) return false;

        $product = dispatch_now(new GetProductTask($this->data['slug']));
        $this->product = $product;
        if(!$product) return false;

        $product->status = $command == 'approve'
                ? $this->approve()
                : $this->reject();

        $product->save();

        return true;

    }

    public function approve()
    {
        event( new ItemApproved( $this->product ) );

        return Product::STATUS['approve'];
    }

    public function reject()
    {
        event( new ItemRejected( $this->product ) );

       return Product::STATUS['reject'];
    }
}
