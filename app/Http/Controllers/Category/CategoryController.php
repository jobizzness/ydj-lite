<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

    public function __construct()
    {

    }

    public function index()
    {
        return Category::all();
    }
}
