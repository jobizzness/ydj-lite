<?php namespace App\Modules\User\Tasks;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class UploadAvatarTask extends Command
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
    private $image;

    /**
     * Create a new command instance.
     *
     * @param $image
     */
    public function __construct($image)
    {
        parent::__construct();
        $this->image = $image;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = str_replace('data:image/png;base64,', '', $this->image);
        $data = str_replace(' ', '+', $data);
        $source = base64_decode($data);

        $name = 'avatar' . request()->user()->username .'/' . rand() . '.jpg';
        Storage::put($name, $source);

        return env('APP_URL') . Storage::url($name);

        //$path = Storage::putFile('avatar', Storage::get('tmp.jpg'));
        //dd($path);
        //Storage::disk('local')->put('imgage.png', $image);
    }
}
