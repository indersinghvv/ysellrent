<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Userproduct;
use Auth;
use Cart;
use App\Http\Requests;
use Illuminate\Http\Request;
class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $userId = Auth::id();
        Cart::session($userId);
        
        
        $carts = Cart::getContent();
        //$productid=Carts::get($rowId);
        foreach ($carts as $cart) {
            $seller[] = Userproduct::find($cart->id)->user->name;
        }
        //dd($seller);
        //$seller=Userproduct::find($items);
        $cart = Cart::getContent();
        $wish_list = app('wishlist');
        $wishlist = $wish_list->getContent();
        $danger_message='0';
        foreach ($cart as $data) { 
            $productdetails=Userproduct::find($data->id);
            if (1==$productdetails->dalete_status) {
                $danger_message='deleted item in your cart list';
            }
            if (0==$productdetails->check_public) {
                $danger_message='some product may be private. please check your product in cart';
                
            }
        }
        $notification = array(
            'message' => $danger_message, 
            'alert-type' => 'error'
        );
        return view('cart', compact('cart', 'seller', 'wishlist','notification'));
    }
    public function additem(Request $request)
    {$userId = Auth::id();
        $productid=$request->get('product_id');
        
        $product=Userproduct::find($productid);
        if ($product->userid==$userId) {
            $notification = array(
                'message' => 'This is your product, you can not add to cart!!', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        Cart::session($userId);
        // add single condition on a cart bases
        $condition1= new \Darryldecode\Cart\CartCondition(array(
            'name' => 'tax',
            'type' => 'tax',
            'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
            'value' => '10%',
            'attributes' => array( // attributes field is optional
                'description' => 'Value added tax',
                'more_data' => 'more data here',
            ),
        ));
        Cart::condition($condition1);
        $product=Userproduct::find($productid);
       
        if(Cart::get($productid)==null||Cart::get($productid)->quantity<$product->stock){
            Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'price' => $product->original_price,            
                'quantity' => 1,
                'attributes' => array(
                    'store_name' => $request->get('store_name'),
                ),
                
            ));
            $notification = array(
                'message' => 'Item has been added to your cart!', 
                'alert-type' => 'success'
            );
            return redirect()->route('cart.index')->with($notification);
        }
        
        $notification = array(
            'message' => 'Item is already in your cart!', 
            'alert-type' => 'error'
        );
        return redirect()->route('cart.index')->with($notification);

    }
    public function update($itemId, $quantity)
    {
        if ($quantity > 0) {
            $userId = Auth::id();
            Cart::session($userId);
            Cart::update($itemId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity,
                ),
            ));
            $notification = array(
                'message' => 'Item has been updated successfully!', 
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        $notification = array(
            'message' => 'Minimum Quantity should be 1', 
            'alert-type' => 'warning'
        );
        return back()->with($notification);

    }
    public function removeitem($itemId)
    {
        $userId = Auth::id();
        Cart::session($userId);
        // removing cart item for a specific user's cart
        // or any string represents user identifier
        Cart::remove($itemId);
        $notification = array(
            'message' => 'Item has been removed!', 
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

}
