<?php

namespace App\Http\Controllers\Media;

use App\Modules\Media\Commands\UploadMediaCommand;
use App\Modules\Media\Requests\CreateMediaRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class MediaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateMediaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMediaRequest $request)
    {
        //only allow IMAGE

        $media = $this->dispatchNow(new UploadMediaCommand(request()->file('file')));
        if(! $media){
            return $this->requestFailed('Opps! There was an error uploading the image');
        }
        return $this->respond($media->id);
    }

    /**
     * @return mixed
     */
    public function saveAsset()
    {
        //Only allow ZIP
        $path = request()->file('file')->store('assets');

        if($path){
            return $this->respond(urlencode (env('APP_URL') .'/storage/'. $path));
        }

        return $this->requestFailed('Opps! There was an error uploading the asset');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
