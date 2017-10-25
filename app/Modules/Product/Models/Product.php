<?php namespace App\Modules\Product\Models;

use App\Media;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'price'
    ];

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
        return $this->belongsToMany('');
    }
}
