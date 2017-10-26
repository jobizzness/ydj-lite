<?php namespace App\Modules\Product\Models;

use App\Modiles\Categories\Models\Category;
use App\Modules\Media\Models\Media;
use App\Modules\Product\Presenter\ProductPresenter;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Product extends Model
{
    use PresentableTrait;

    protected $fillable = [
        'title', 'description', 'price'
    ];

    protected $presenter = ProductPresenter::class;


    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
