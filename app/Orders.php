<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Cart;

class Orders extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id','billing_email', 'billing_name','billing_address','billing_city','billing_province','billing_country','billing_postalcode','billing_phone','billing_name_on_card','billing_address','billing_discount','billing_discount_code','billing_subtotal','billing_tax','billing_total','payment_gateway','shipped','error'
  ];
    public function orders_userproduct(){
      return $this->hasMany('App\Orders_userproduct', 'orders_id');
    }
    /**
     * The userproduct that belong to the orders.
     */
    public function userproduct()
    {
        return $this->belongsToMany(Userproduct::class, 'orders_userproducts')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity');
    }
}
