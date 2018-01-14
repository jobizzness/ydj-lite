<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Modules\Authentication\Commands\AuthenticateWithSocialCommand;
use App\Modules\User\Commands\RegisterUserCommand;
use App\Modules\User\Requests\RegisterUserRequest;
use App\Modules\User\Transformers\UserTransformer;
use Illuminate\Http\Request;

class RegisterController extends ApiController
{
    protected $transformer;


    /**
     * Create a new controller instance.
     *
     * @param UserTransformer $transformer
     */
    public function __construct(UserTransformer $transformer)
    {
        $this->middleware('guest');
        $this->transformer = $transformer;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param RegisterUserRequest $request
     * @return mixed
     */
    public function create(RegisterUserRequest $request)
    {
        $user = $this->dispatchNow(new RegisterUserCommand($request));
        if($user){
            return $this->respond([
               "response" => [
                    "data" => $this->transformer->transform($user),
                    "access_token" => $user->createToken('API Token')->accessToken
               ],

            ]);
        };

        return $this->respondWithError('There was an error creating the user.');

    }

    /**
     * Redirect user to login to thirdparty.
     *
     * @param null $provider
     * @param Request $request
     * @return mixed
     */
    public function getSocialAuth($provider = null, Request $request)
    {
        if (!config("services.$provider")) abort('404');
        return $this->dispatchNow(new AuthenticateWithSocialCommand($provider, ($request->has('code') || $request->has('oauth_token')), $this));
    }

    /**
     * @param $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userHasLoggedIn($user){
        $token = $user->createToken('API Token')->accessToken;
        return redirect("https://market.yourdesignjuice.com/?code=$token");
    }
}
