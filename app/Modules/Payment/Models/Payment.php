<?php

namespace App\Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = [
        'order_id',
        'transaction_id',
        'amount',
        'currency'
    ];
    /**
     * @param $amount
     * @return mixed
     */
    public static function chargeFees($amount)
    {
        return $amount;
    }
}
