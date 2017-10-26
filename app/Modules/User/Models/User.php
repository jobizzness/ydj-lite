<?php
namespace App\Modules\User\Models;


use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laracasts\Presenter\PresentableTrait;
use App\Modules\User\Presenters\UserPresenter;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait, PresentableTrait;

    protected $presenter = UserPresenter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'balance_id', 'social_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function makeSeller()
    {
        $this->is_seller = true;
        $this->save();
        //I can dispatch events here if i want...
    }

    public function isSeller()
    {
        return (bool) $this->is_seller;
    }

}
