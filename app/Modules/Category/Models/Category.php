<?php namespace App\Modules\Category\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
      'name', 'slug', 'title', 'description'
    ];

    /**
     * Get the products associated with the category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
