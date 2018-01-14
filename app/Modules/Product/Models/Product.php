<?php namespace App\Modules\Product\Models;

use App\Modules\Category\Models\Category;
use App\Modules\Media\Models\Media;
use App\Modules\Product\Presenter\ProductPresenter;
use App\Modules\User\Models\User;
use Conner\Likeable\LikeableTrait;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Product extends Model
{
    use PresentableTrait, LikeableTrait;

    protected $fillable = [
        'title',
        'description',
        'price',
        'extensions',
        'asset',
        'is_free',
        'category_id',
        'username'
    ];

    protected $softDelete = true;

    const STATUS = [
        'draft' => 'DRAFT',
        'publish' => 'PUBLISHED',
        'approve'  => 'APPROVED',
        'reject'  => 'REJECTED'
    ];

    /**
     * @var string
     */
    protected $presenter = ProductPresenter::class;


    public function scopeCategory($query, $category)
    {
        if($category){
            return $query->where('category_id', $category);
        }
    }
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
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function changeStatus($status)
    {

    }

}
