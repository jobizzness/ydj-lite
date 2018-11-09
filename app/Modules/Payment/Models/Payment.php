<?php namespace App\Modules\Payment\Models;

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
     * Charge Fees and return the updated price
     * @param $price
     * @return mixed
     * @internal param $amount
     */
    public static function chargeFees($price=1)
    {

    }
}
