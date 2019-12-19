<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Darryldecode\Cart\CartCollection;

class CartStorage extends Model
{
    
    public function has($key)
    {
        return CartStorageModel::find($key);
    }
    public function get($key)
    {
        if($this->has($key))
        {
            return new CartCollection(CartStorageModel::find($key)->cart_data);
        }
        else
        {
            return [];
        }
    }
    public function put($key, $value)
    {
        if($row = CartStorageModel::find($key))
        {
            // update
            $row->cart_data = $value;
            $row->save();
        }
        else
        {
            CartStorageModel::create([
                'id' => $key,
                'cart_data' => $value
            ]);
        }
    }
}
