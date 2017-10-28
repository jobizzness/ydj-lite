<?php namespace App\Modules\User\Commands;

use App\Modules\User\Tasks\UploadAvatarTask;
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
        //Check if user changed their avatar
        if(array_key_exists('avatar_image', $this->data)){
            $this->data['avatar'] = dispatch_now(new UploadAvatarTask($this->data['avatar_image']));
        }

      if(request()->user()->update($this->data)){
          return request()->user();
      }
    }
}
