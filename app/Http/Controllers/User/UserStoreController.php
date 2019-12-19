<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Username;
use App\Userproduct;

class UserStoreController extends Controller
{
    public function index(){

    }
    public function userstore($username)
    {
            $user = Username::where('username' , $username)->orWhere('temp_username', $username)->firstOrFail();
            $storename=$username;
            $productlists=Userproduct::where('user_id', $user->user_id)->where('check_public', '1')->where('delete_status', '0')->where('check_product_ban', '0')->get();
            return view('user.userstore',compact('productlists','storename'));
        dd('success');
    }
}
