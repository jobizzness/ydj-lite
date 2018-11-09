<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Modules\Category\Requests\UpdateUserRequest;
use App\Modules\User\Commands\UpdateUserCommand;
use App\Modules\User\Transformers\ProfileTransformer;
use App\Modules\User\Commands\ViewUserProfileCommand;
use Illuminate\Http\Request;
use App\Modules\User\Transformers\UserTransformer;
use Illuminate\Support\Facades\Storage;

/**
 *
 * Class UserController
 * @package App\Http\Controllers\User
 * @author Jobizzness <jobizzness@gmail.com>
 */
class UserController extends ApiController
{

    /**
     * @var UserTransformer
     */
    protected $transformer;

    /**
     * @var Request
     */
    private $request;

    /**
     * UserController constructor.
     * @param UserTransformer $transformer
     * @param Request $request
     */
    public function __construct(UserTransformer $transformer, Request $request)
    {
        $this->transformer = $transformer;
        $this->request = $request;
    }

    /**
     * Return the currently logged in user
     * Array of the users Data
     * @return mixed
     */
    public function index()
    {
        return $this->respond($this->transformer->transform($this->request->user()));
    }

    /**
     * @param UpdateUserRequest $request
     * @return mixed
     */
    public function update(UpdateUserRequest $request)
    {
        $updated = $this->dispatchNow(new UpdateUserCommand($request->all()));

        return !$updated ? $this->requestFailed('Could not update user') :
                $this->respond($this->transformer->transform($updated));
    }

    /**
     * Get a the profile of a user by their username
     * @param $username
     * @param ProfileTransformer $profileTransformer
     * @return mixed
     */
    public function profile($username, ProfileTransformer $profileTransformer)
    {
        $profile = $this->dispatchNow(new ViewUserProfileCommand($username));

        if(!$profile) return $this->NotFound('This user does not exist');

        return $profileTransformer->transform($profile);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function uploadCover(Request $request)
    {
       $file = $request->file('file')->store('covers');

        $cover = env('APP_URL') . Storage::url($file);
        $request->user()->highlight = $cover;
        $request->user()->save();

        return $cover;


    }

    /**
     * Makes the current user a seller
     * @return mixed
     */
    public function makeSeller()
    {
        if(!request()->user()->is_seller){
            request()->user()->makeSeller();
        }
        return $this->respond(true);
    }

    /**
     * Checks if the current user is a seller.
     * @return bool
     */
    public function isSeller()
    {
        return (bool) $this->is_seller;
    }
}