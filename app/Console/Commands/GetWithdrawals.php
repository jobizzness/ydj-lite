<?php

namespace App\Console\Commands;

use App\Withdrawal;
use Illuminate\Console\Command;

class GetWithdrawals extends Command
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
    private $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->user = request()->user();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->user->isAdmin()){
            return Withdrawal::orderBy('created_at')
                ->where('status', Withdrawal::STATUS['pending'])
                ->paginate(10);
        }

        return $this->user->withdrawals()
                ->paginate(10);
    }
}
