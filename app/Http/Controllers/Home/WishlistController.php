<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Auth;
class WishlistController extends Controller
{
    public function index()
    {
       
            $items = [];
            $wish_list = app('wishlist');
            $wish_list->getContent()->each(function($item) use (&$items)
            {
                $items[] = $item;
            });
            return view('cart', compact('cart', 'seller'));
    }
    public function add( Request $request)
    {
        $userId=Auth::id();
        Cart::session($userId);
        $itemId=$request->get('itemId');
        $wish_list = app('wishlist');
        $item=Cart::get($itemId);
        $id = $item->id;
        $name = $item->name;
        $price = $item->price;
        $qty = $item->quantity;
        $store_name=$item->attributes->store_name;
        $wish_list->add($id, $name, $price, $qty,  array('store_name' => $store_name));
        $notification = array(
            'message' => 'Item has been added to wishlist!', 
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    public function delete($id)
    {
        $wish_list = app('wishlist');
        $wish_list->remove($id);
        $notification = array(
            'message' => 'Wishlist Item has been deleted', 
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    public function MoveToCart(Request $request)
    {
        $userId=Auth::id();
        Cart::session($userId);
        $itemId=$request->get('id');
        $wish_list = app('wishlist');
        $item=$wish_list->get($itemId);
        $store_name=$item->attributes->store_name;
        
        $wish_list->remove($itemId);
        $notification = array(
            'message' => 'Wishlist Item has been moved to cart', 
            'alert-type' => 'success'
        );
        return redirect()->route('cart.additem',['product_id'=>$itemId,'store_name'=>$store_name])->with($notification);
    }
}
