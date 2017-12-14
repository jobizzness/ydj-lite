<?php

namespace App\Modules\User\Commands;

use App\Modules\User\Tasks\GetUserTask;
use App\Modules\User\Data\Repository\UserRepositoryInterface;
use Illuminate\Console\Command;

class ViewUserProfileCommand extends Command
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
    private $username;

    /**
     * @var mixed
     */
    private $users;

    /**
     * Create a new command instance.
     *
     * @param $username
     */
    public function __construct($username)
    {
        parent::__construct();

        $this->users = resolve(UserRepositoryInterface::class);
        $this->username = $username;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return (new GetUserTask($this->username))->handle();
    }
}
