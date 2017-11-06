<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * The user wants to buy something.
     * Lets take a look.
     *
     * @param $userId
     * @return mixed
     */
    public function getCheckout($userId)
    {
      // Get the user and their cart
      // 
    }
}
