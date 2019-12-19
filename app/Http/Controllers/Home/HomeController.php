<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Username;
use App\Userproduct;
use App\UserProductLink;

class HomeController extends Controller
{

    public function index()
    {

        $productlists = Userproduct::where('check_public', '1')->where('delete_status', '0')->where('check_product_ban', '0')->paginate(8);

        return view('welcome', ['productlists' => $productlists]);

    }
    public function notification()
    {
        session()->set('success','Item created successfully.');


        return view('notification-check');
    }

    public function productshow($productslug)
    {
        if ($productslug == Userproduct::where('slug', $productslug)->value('slug')) {
            $products = Userproduct::where('slug', $productslug)->first();
            $storename = Username::where('user_id', $products->user_id)->first();
            $linkedproducts = UserProductLink::where('product_id', $products->id)->get();

            if (count($linkedproducts) == 0) {
                $stock = $products->stock;
                $linkedstorename[] = $storename->username;

                return view('productshow', compact('products', 'linkedstorename', 'stock'));
            } else {

                foreach ($linkedproducts as $linkedproduct) {
                    $storenameforlinkedproduct = Username::where('user_id', $linkedproduct->user_id)->first();
                    $tempstorenameforlinkedproducts = $storenameforlinkedproduct->temp_username;
                    $originalstorenameforlinkedproduct = $storenameforlinkedproduct->temp_username;
                    if ($products->stock != 0) {
                        if ($storename->username == null) {
                            $linkedstorename[] = $storename->temp_username;
                        } else {
                            $linkedstorename[] = $storename->username;
                        }

                    }

                    if ($linkedproduct->stock == 0) {
                        if (count($linkedstorename) == 1) {

                        } else {
                            $linkedstorename[] = '0';
                        }

                    } else {
                        if ($storenameforlinkedproduct->username == null) {
                            $linkedstorename[] = $storenameforlinkedproduct->temp_username;
                        } else {
                            $linkedstorename[] = $storenameforlinkedproduct->username;
                        }
                    }

                }

                if ($products->delete_status == 1) {
                    $stock = 0;
                } elseif ($products->checkpublic == 0) {
                    $stock = 0;
                } else {
                    $stock = $products->stock;
                }

                foreach ($linkedproducts as $linkedproduct) {

                    $stock = $linkedproduct->stock + $stock;
                }

                return view('productshow', compact('products', 'storename', 'stock', 'linkedstorename'));
            }

        } else {
            return redirect('/');
        }
    }
}
