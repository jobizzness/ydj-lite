<?php

namespace App\Console\Commands;

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
     * @param $command
     * @param $data
     */
    public function __construct($command, $data)
    {
        parent::__construct();
        $this->command = $command;
        $this->data = $data;

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

        if($product->status === Product::STATUS['draft']){
            $product->status = Product::STATUS['publish'];
            $product->save();
        }
        return true;
    }

    private function rejectOrApprove($command)
    {
        if(!request()->user()->hasRole('admin')) return false;

        $product = dispatch_now(new GetProductTask($this->data['slug']));
        if(!$product) return false;

        $product->status = Product::STATUS[$command];
        $product->save();

        return true;
        //user must be admin
    }
}
