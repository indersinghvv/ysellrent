<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProductLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','product_id','title','slug','author','photo1','photo2','photo3','category', 'stock','sold_unit', 'original_price','selling_price','available_for','shipping_service','check_public','check_product_ban','check_linked','product_ban_reason','condition',
    ];

    public function userproduct(){
        return $this->hasMany(userproduct::class);
      }
    /**
     * Get the soldcount record associated with the user.
     */
    public function soldcount()
    {
        return $this->hasOne('App\SoldCount','product_id');
    }
}
