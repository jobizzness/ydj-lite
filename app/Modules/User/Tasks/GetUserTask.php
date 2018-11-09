<?php namespace App\Modules\User\Tasks;

use App\Modules\User\Data\Repository\UserRepositoryInterface;
use Illuminate\Console\Command;

class GetUserTask extends Command
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
    protected $users;
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
        $this->users = resolve(UserRepositoryInterface::class);
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
            return $this->users->findById($this->identifier);
        }
        return $this->users->findByNickname($this->identifier);
    }
}
