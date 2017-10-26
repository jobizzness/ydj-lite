<?php namespace App\Modules\User\Commands;

use Illuminate\Console\Command;

class UpdateUserCommand extends Command
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
     * @var array
     */
    private $data;

    /**
     * Create a new command instance.
     *
     * @param array $data
     */
    public function __construct(Array $data)
    {
        parent::__construct();

        $this->data = $data;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      if(request()->user()->update($this->data)){
          return request()->user();
      }
    }
}
