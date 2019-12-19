<?php

namespace App\Http\Controllers\User;

use App\dAddress;
use App\Http\Controllers\Controller;
use App\user;
use App\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
class Usercontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        
        if (Gate::allows('isUser')) {
            $temp_username = uniqid();
            $user = User::find(Auth::id());
            $username = Username::where('user_id', Auth::id())->value('temp_username');
            if ($username == null) {
                $username1 = new Username;
                $username1->temp_username = $temp_username;
                $user->username()->save($username1);
            }

            return view('user.dashboard');
        } else {
            return view('admin.dashboard');
        }
        if (Gate::denies('isUser')) {
            echo 'Registered user role are not allowed';
        } else {
            echo 'Registered user role is allowed';
            
        }
    }
    public function showprofile()
    {
        if (User::find(Auth::id())->username->username == null) {
            $temp_username = User::find(Auth::id())->username->temp_username;
            $status="";
        } else {    
            $temp_username = User::find(Auth::id())->username->username;
            $status="disabled invisible";
        }
        return view('user.profile')->with([
            'temp_username'=> $temp_username,
            'status'=> $status
        ]);
    }
    public function updateStoreShow()
    {
        
        if (User::find(Auth::id())->username->username == null) {
            $temp_username = User::find(Auth::id())->username->temp_username;
        } else {
            if (User::find(Auth::id())->username->username !== null) {
                return redirect()->route('profile');
            }
            $temp_username = User::find(Auth::id())->username->username;
        }
        return view('user.updateusername')->with('temp_username', $temp_username);
    }
    public function updateStorenamecheck(Request $request)
    {
        if ($request->get('username')) {
            $username = $request->get('username');
            $data = Username::where('username', $username)->count();
            if ($data > 0) {
                echo 'not_unique';
            } else {
                echo 'unique';
            }
        }
    }
    public function updateStorename(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:usernames|max:30|min:6',
        ]);
        $temp_username=$request->get('temp_username');
        $username=$request->get('username');
        
        Username::where('temp_username',$temp_username)->update(['username' => $username]);
        return redirect()->route('profile');

    }
    public function showaddress()
    {
        $userid = Auth::id();
        $myaddresses = dAddress::get()->where('userid', $userid);
        return view('user.myaddress', compact('myaddresses'));

    }
    public function deleteAddress($address_id)
    {
        $address = dAddress::find($address_id);
        $address->delete();
        return redirect()->route('myaddress');
    }

}
