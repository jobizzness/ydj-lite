<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Modules\User\Transformers\UserTransformer;

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
     * Update the current user's info
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
    }
    public function store($id)
    {
    }
}