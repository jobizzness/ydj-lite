<?php

namespace App\Modules\Media\Commands;

use App\Modules\Repository\MediaRepositoryInterface;
use Illuminate\Console\Command;

class UploadMediaCommand extends Command
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
     * @var UploadedFile
     */
    private $file;
    /**
     * @var UploadedFile
     */
    private $media;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        parent::__construct();

        $this->media = resolve(MediaRepositoryInterface::class);
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = 'ad_' . md5($this->file->getClientOriginalName() . time()) . $this->file->extension();
        //We might want to create more versions here
        return $this->media->store($this->file, $name);
    }
}
