<?php

namespace App;

use App\Modules\User\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = [
        'amount',
        'code',
        'status',
        'user_id',
        'paypal'

    ];

    const STATUS = [
        'pending' => 'PENDING',
        'publish' => 'PUBLISHED',
        'approve'  => 'APPROVED',
        'reject'  => 'REJECTED'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function makeCode()
    {
        $prefix = 'YDJ00';

        $code = $prefix . mt_rand ( 100 , 10000 );

        $record = Withdrawal::where('code', $code)->first();

        if($record){
            return self::makeCode();
        }

        return $code;

    }
}
