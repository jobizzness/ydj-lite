<?php

namespace App\Modules\User\Commands;

use App\Modules\User\Data\Repository\UserRepositoryInterface;
use App\Modules\User\Requests\RegisterUserRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class RegisterUserCommand extends Command
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
    protected $data = [];

    /**
     * Create a new command instance.
     *
     * @param $request
     */
    public function __construct(RegisterUserRequest $request)
    {
        $this->data = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ];

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return App::make(UserRepositoryInterface::class)->create([
            "email" => $this->data['email'],
            "password" => $this->data['password'],
            "name" => $this->data['name']
        ]);

    }
}
