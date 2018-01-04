<?php namespace App\Modules\Category\Models;

use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
      'name', 'slug', 'description'
    ];

    /**
     * Get the products associated with the category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->HasMany(Product::class);
    }
}
