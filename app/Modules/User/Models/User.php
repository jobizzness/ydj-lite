<?php
namespace App\Modules\User\Models;


use App\Cart;
use App\Favorite;
use App\Modules\Order\Models\Order;
use App\Modules\Product\Models\Product;
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
        'name', 'email', 'password', 'avatar', 'company_name', 'location', 'highlight',
        'bio', 'lang', 'gender', 'birth', 'nickname'
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

    /**
     * @return bool
     */
    public function isSeller()
    {
        return (bool) $this->is_seller;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function cart()
    {
        $cart = Cart::where('user_id', $this->id)->get();

        $results = [];

        if($cart){
            foreach($cart as $item){
                $results[] = Product::where('id', $item->item_id)->first();
            }
        }
        return collect($results);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites()
    {
        return $this->belongsToMany(Favorite::class, 'favorites', 'user_id', 'item_id')->withTimeStamps();
    }

}
