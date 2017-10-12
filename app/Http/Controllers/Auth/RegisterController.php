<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Modules\User\Commands\RegisterUserCommand;
use App\Modules\User\Requests\RegisterUserRequest;
use App\Modules\User\Transformers\UserTransformer;
use App\User;


class RegisterController extends ApiController
{


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
                    "access_token" => $user->token()
               ],

            ]);
        };

        return $this->respondWithError('There was an error creating the user.');

    }
}
