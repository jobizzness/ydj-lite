<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new module.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument('name');

        if (!is_dir('app/Modules/'.ucfirst($module))) {
            mkdir('app/Modules/'.ucfirst($module), 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Commands', 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Models', 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Repository', 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Requests', 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Tasks', 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Transformers', 0777, true);
            mkdir('app/Modules/'.ucfirst($module).'/Presenters', 0777, true);
        }

    }
}
