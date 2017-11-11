<?php

namespace App\Http\Controllers\Payment;

use App\Console\Commands\GetWithdrawals;
use App\Http\Controllers\ApiController;
use App\Http\Requests\MakeWithdrawalRequest;
use App\Withdrawal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawalController extends ApiController
{

    public function __construct()
    {

    }

    public function index()
    {
        $user = request()->user();

        //validation
        if(!$user->isSeller() || !$user->isAdmin()) return;

        $items = $this->dispatchNow(new GetWithdrawals());

        if(! $items){
            return $this->NotFound('No records found!');
        }

        return $this->respond([
            'data' => $this->transformCollection($items),
            'page_info' => [
                'has_more' => $items->hasMorePages()
            ]
        ]);
    }

    private function transform($item)
    {
        return [
            "date"          => $item->created_at->toDateString(),
            "code"          => $item->code,
            "withdrawer"    => $item->paypal,
            "amount"         => number_format((float) $item->amount, 2),
            "status"        => array_search($item->status, Withdrawal::STATUS)
        ];
    }

    private function transformCollection($items)
    {
        return $items->transform(function ($item){
            return $this->transform($item);
        });
    }

    public function approve()
    {
        
    }

    public function reject()
    {
        
    }


    public function store(MakeWithdrawalRequest $request)
    {
        $withdrawal = new Withdrawal();

        $withdrawal->amount = $request->amount;
        $withdrawal->status = Withdrawal::STATUS['pending'];
        $withdrawal->user_id = request()->user()->id;
        $withdrawal->code = Withdrawal::makeCode();
        $withdrawal->paypal = request()->user()->billing;

        $withdrawal->save();

        $this->respond($this->transform($withdrawal));

    }
    
}
