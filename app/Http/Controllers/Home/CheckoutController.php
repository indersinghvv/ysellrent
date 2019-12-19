<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use DB;
use Auth;
use App\dAddress;
use App\orders;
use App\Userproduct;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $userId = Auth::id();
        Cart::session($userId);
        if(Cart::getTotalQuantity()==0){
            return redirect()->route('/');
        }
        $userid = Auth::id();
        $myaddresses = dAddress::get()->where('userid', $userid); 
        $cartdata=Cart::getcontent();
        foreach ($cartdata as $data) { 
            $productdetails=Userproduct::find($data->id);
            if (1==$productdetails->dalete_status) {
                $notification = array(
                    'message' => 'deleted item in your cart list, please remove that!!', 
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
            if (0==$productdetails->checkpublic) {
                $notification = array(
                    'message' => 'some product may be private. please check your product in cart', 
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
           
        return view('checkout',[
            'data' => Cart::getContent(),
            'myaddresses' =>$myaddresses
          ]);
    }
    public function placeOrder(Request $request){
        $userId = Auth::id();
        Cart::session($userId);
        $this->validate($request, [
            'fullname' => 'required|min:5|max:35',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'city' => 'required|min:5|max:25',
            'state' => 'required|min:5|max:25',
            'country' => 'required',
            'fullAddress' => 'required',
            'zip' => 'required|numeric'
            ]);
        $country=$request->country;
        $address = new dAddress;
        $user = Auth::user();
        $userid=Auth::id();
        $address->userid = $userid;
        $address->fullname = $request->fullname;
        $address->email = $request->email;
        $address->phone = $request->phone;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->country = $country;
        $address->fullAddress = $request->fullAddress;
        $address->zip = $request->zip;
        $address->save();
        $user = Auth::user();
        $userid=Auth::id();
        $order = $user->orders()->create([
            'user_id'=>$userid,
            'billing_email'=>$request->email,
            'billing_name'=>$request->fullname,
            'billing_address'=>$request->fullAddress,
            'billing_city'=>$request->city,
            'billing_province'=>$request->state,
            'billing_country'=>$country,
            'billing_postalcode'=>$request->zip,
            'billing_phone'=>$request->phone,
            'billing_name_on_card'=>'',
            'billing_discount'=>'0',
            'billing_discount_code'=>'',
            'billing_subtotal'=>Cart::getSubtotal(),
            'billing_tax'=>Cart::getCondition('tax')->getValue(),
            'billing_total'=>Cart::getTotal(),
            'payment_gateway'=>Cart::getTotal(),
            'Shipped'=>'',
            'error'=>'',

        ]); // insert order table data
        // place order and insert data to orders_products
        foreach(Cart::getContent() as $cData){
            $order->userproducts()->attach($cData->id,[
            'qty' => $cData->quantity
            ]);
        } 
        
         $address->save();
        
        Cart::clear();
        return redirect()->route('checkout.thankyou');
    }
    public function placeOrderWithSavedAddress($address_id)
    {   
        
        $userId = Auth::id();
        Cart::session($userId);
        
        $user = Auth::user();
        $address = dAddress::find($address_id);
        $order = $user->orders()->create([
            'user_id'=>$address->userid,
            'billing_email'=>$address->email,
            'billing_name'=>$address->fullname,
            'billing_address'=>$address->fullAddress,
            'billing_city'=>$address->city,
            'billing_province'=>$address->state,
            'billing_country'=>$address->country,
            'billing_postalcode'=>$address->zip,
            'billing_phone'=>$address->phone,
            'billing_name_on_card'=>'',
            'billing_discount'=>'0',
            'billing_discount_code'=>'',
            'billing_subtotal'=>Cart::getSubtotal(),
            'billing_tax'=>Cart::getCondition('tax')->getValue(),
            'billing_total'=>Cart::getTotal(),
            'payment_gateway'=>Cart::getTotal(),
            'Shipped'=>'',
            'error'=>'',

        ]); // insert order table data
        // place order and insert data to orders_products
        foreach(Cart::getContent() as $cData){
            $order->userproduct()->attach($cData->id,[
                'price' => $cData->price,
            'qty' => $cData->quantity
            ]);
            $oldstock=Userproduct::where('id', $cData->id)->value('stock');
            if($oldstock>0){
                $newstock=$oldstock-$cData->quantity;
                Userproduct::where('id', $cData->id)->update(['stock' => $newstock]);
            }
           
        }
        
        //Userproduct::update(['stock' => 1]);
       
        Cart::clear();
        return redirect()->route('checkout.thankyou');
    }
    public function thankyou()
    {
        return view('thankyou');
    }
    public function deleteAddress($address_id)
    {
        $address=dAddress::find($address_id);
        $address->delete();
        
        return redirect()->route('checkout.index');
    }
}
