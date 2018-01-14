<?php

namespace App;

use App\Modules\Product\Models\Product;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product',
        'seller',
        'buyer'
        ];


    public function seller()
    {
        return $this->belongsTo(User::class, 'seller');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer');
    }
}
