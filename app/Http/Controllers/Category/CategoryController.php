<?php namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Modules\Category\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        if(!$request->user()->isAdmin()) return;

        Category::create([
            'slug'              => $this->generateSlug($request->name),
            'name'              => $request->name,
            'description'       => $request->description
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return mixed|void
     */
    public function update(Request $request, Category $category)
    {
        if(!$request->user()->isAdmin()) return;

        $category->fill($request->all());
        return $this->respond($category->save());
    }

    /**
     * Generates Unique Slug
     *
     * @param $title
     * @return mixed
     */
    public function generateSlug($title)
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $title);

        $slugExists = Category::where('slug', $slug)->first();

        if($slugExists){
            return $this->generateSlug($slug.substr(md5(mt_rand()), 0, 4));
        }

        return $slug;
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return mixed|void
     */
    public function destroy(Request $request, Category $category)
    {
        if(!$request->user()->isAdmin()) return;
        return $this->respond($category->delete());
    }
}
