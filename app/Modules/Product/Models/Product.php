<?php namespace App\Modules\Product\Models;

use App\Modules\Category\Models\Category;
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

    /**
     * @var string
     */
    protected $presenter = ProductPresenter::class;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
