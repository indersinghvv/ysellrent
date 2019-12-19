<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Orders;
use Auth;
use App\dAddress;
use App\Userproduct;
class MyorderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function allorder()
    {
        
       $orders = auth()->user()->orders()->with('userproduct')->latest()->limit(3)->get(); // fix n + 1 issues
        
       return view('user.myorder', compact('orders'));
    }
    public function allbuyorder()
    {
        
       $orders = auth()->user()->orders()->with('userproduct')->latest()->get(); // fix n + 1 issues
        
       return view('user.allbuyorder', compact('orders'));
    }
    public function onebuyorder( Orders $order)
    {
        if (auth()->id() !== $order->user_id) {
            return back()->withErrors('You do not have access to this!');
        }

        $products = $order->userproduct;
        $userid = Auth::id();
        $myaddresses = dAddress::find($userid);
        return view('user.showoneorder')->with([
            'order' => $order,
            'products' => $products,
            'myaddresses'=>$myaddresses
        ]);
    }
}
