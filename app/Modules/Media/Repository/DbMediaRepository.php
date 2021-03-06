<?php namespace App\Modules\Media\Repository;

use App\Modules\Media\Models\Media;
use App\Modules\Repository\MediaRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DbMediaRepository implements MediaRepositoryInterface
{
    /**
     * @param $file
     * @param $name
     * @return Media
     */
    public function store($file, $name)
    {
        $path = Storage::putFile('media', $file);

        if($path){

            $media = new Media;
            $media->src = env('APP_URL') .'/storage/'. $path;
            $media->media_type = $file->getMimeType();
            $media->description = $file->getClientOriginalName();
            $media->product_id = null;
            $media->save();

            return $media;
        }

    }
}