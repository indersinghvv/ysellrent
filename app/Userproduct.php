<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Userproduct extends Model 
{
    use Searchable;
    public $asYouType = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','title','by','slug','author','photo1','photo2','photo3','category', 'stock','sold_unit', 'product_id', 'original_price','selling_price','available_for','shipping_service','check_public','check_product_ban','available_for','product_ban_reason','condition',
    ];
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
/**
     * Get the soldcount record associated with the user.
     */
    public function soldcount()
    {
        return $this->hasOne('App\SoldCount','product_id');
    }
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    
    /**
     * The orders that belong to the user.
     */
    public function orders()
    {
        return $this->belongsToMany(Orders::class, 'orders_userproducts');
    }
    public function user()
      {
          return $this->belongsTo('App\User', 'user_id');
      }
}
