<?php

namespace App\Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{


    /**
     * @param $amount
     * @return mixed
     */
    public static function chargeFees($amount)
    {
        return $amount;
    }
}
