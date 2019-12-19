<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Userproduct;
use App\UserProductLink;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use Storage;
use Illuminate\Support\Facades\DB;
class SellController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = Auth::id();
        $userproductslists = Userproduct::where('user_id', $userid)->where('delete_status', '0')->get();
        $userlinkedproduct=UserProductLink::where('user_id',$userid)->get();
        $collection = collect($userproductslists);
        $userproductslists = $collection->merge($userlinkedproduct)->sortByDesc('created_at')->paginate(4);
        return view('user.products.productslist', compact('userproductslists','userlinkedproduct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addproduct()
    {
        return view('user.products.addproduct');
    }
    public function AddUsersProduct($productid)
    {
        $userid=Auth::id();
        $product_details=Userproduct::where('id',$productid)->first();
        $linkedproduct=UserProductLink::where('product_id',$productid)->first();
        if($linkedproduct==null){
            if($product_details->userid==$userid){
                $notification = array(
                    'message' => 'Item is already in your selling list. To Check Goto->dashboard->sell', 
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
            else{
                $userproductlink = new UserProductLink([
                    'user_id' => $userid,
                    'product_id' => $productid,
                    'title' => $product_details->title,
                    'slug' => $product_details->slug,
                    'author' => $product_details->author,
                    'photo1' => $product_details->photo1,
                    'photo2' => '',
                    'photo3' => '',
                    'stock' => '0',
                    'original_price' => $product_details->original_price,   
                    'selling_price' => $product_details->selling_price,   
                    'available_for' => $product_details->available_for,
                    'check_public' => '0',
                    'check_product_ban' => '0',
                    'product_ban_reason' => 'nothing',
                    'shipping_service' => $product_details->shipping_service,
                    'condition' => '1',
                ]);
                $userproductlink->save();
                $notification = array(
                    'message' => 'Succesfully Added !!. Now find and change your product to public.  ', 
                    'alert-type' => 'success'
                );
                return redirect('user/sell')->with( $notification);
            }
        }
        if($linkedproduct->user_id==$userid||$product_details->userid==$userid){
            $notification = array(
                'message' => 'Item is already in your selling list. To Check Goto->dashboard->sell', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        
        }
        else {
        
        $userproductlink = new UserProductLink([
            'user_id' => $userid,
            'product_id' => $productid,
            'title' => $product_details->title,
            'slug' => $product_details->slug,
            'author' => $product_details->author,
            'photo1' => $product_details->photo1,
            'photo2' => '',
            'photo3' => '',
            
            'stock' => $product_details->stock,
            'original_price' => $product_details->original_price,
            'selling_price' => $product_details->selling_price,
            'available_for' => $product_details->available_for,
            'check_public' => '1',
            'check_product_ban' => '0',
            'product_ban_reason' => 'nothing',

            'shipping_service' => $product_details->shippingservice,
            'condition' => '1',

        ]);
        $userproductlink->save();
        $notification = array(
            'message' => 'Succesfully Added !!. Now find and change your product to public.  ', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }

    }
    public function linkedProductUpdate(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required',
            'value' => 'required',
            'sellingprice' => 'required',
        ]);
        $id=$request->productid;
        $userproducts = UserProductLink::find($id);
        $userproducts->title = $request->get('title');
        $userproducts->author = $request->get('author');       
        $userproducts->stock = $request->get('stock');
        $userproducts->original_price = $request->get('value');
        $userproducts->selling_price = $request->get('sellingprice');
        $userproducts->update();
        $notification = array(
            'message' => '"'.$userproducts->title.'" Updated Successfully!!', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function updateLinkedPublicStatus(Request $request)
    {
        $request->validate([
            'productid' => 'required',
            'public_status' => 'required',
        ]);
        $id=$request->productid;
        $userproducts = UserProductLink::find($id);
        $userproducts->check_public = $request->get('public_status');
        $userproducts->update();
        if ($request->get('public_status')==1) {
            $status='public (Everyone can see)';
        }
        else{
            $status='private (only you can see) ';
        }
        $notification = array(
            'message' => '"'.$userproducts->title.'" is now '.$status,
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
    public function deletelinkedproduct($id)
    {

        $userid = Auth::id();
        if ($userid == UserProductLink::where('id', $id)->value('user_id')) {
            Userproduct::where('id', $id)->update(['delete_status' => 1]);
            $products = UserProductLink::where('id', $id)->first();
            
            $products->delete();
            $notification = array(
                'message' => '"'.$products->title.'" has been deleted successfully',
                'alert-type' => 'success'
            );
            
        
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'something went wrong',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required',
            'value' => 'required',
            'selling_price' => 'required',
            'photo1' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $slug = Str::slug($request->get('title') . '-by-' . $request->get('author'), '-');
        $originalImage = $request->file('photo1');
        $thumbnailImage = Image::make($originalImage);
        $thumbnailPath = public_path() . '/storage/thumbnails/';
        $originalPath = public_path() . '/storage/images/';
        $userid = Auth::user()->id;
        $imagename = time() . $originalImage->getClientOriginalName();
        $userproducts = new Userproduct([
            'user_id' => $userid,
            'title' => $request->get('title'),
            'slug' => $slug,
            'author' => $request->get('author'),
            'photo1' => $imagename,
            'photo2' => '',
            'photo3' => '',
            'category' => '',
            'stock' => $request->get('stock'),
            'original_price' => $request->get('value'),
            'selling_price' => $request->get('selling_price'),
            'available_for' => $request->get('Available4sell'),
            'shipping_service' => $request->get('shippingservice'),
            'condition' => $request->get('Condition'),

        ]);
        $thumbnailImage->resize(300, 450);
        $thumbnailImage->save($originalPath . $imagename);
        $thumbnailImage->resize(200, 300);
        $thumbnailImage->save($thumbnailPath . $imagename);
        $userproducts->save();
        $notification = array(
            'message' => '"'.$request->get('title').'" saved!',
            'alert-type' => 'success'
        );
        return redirect('user/sell')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userid = Auth::id();
        if ($userid == Userproduct::where('id', $id)->value('user_id')) {
            $products = Userproduct::find($id);
            return view('user.products.productedit', compact('products'));
        } else {
            if ($userid == Userproductlink::where('product_id', $id)->value('user_id')) {
                $products = Userproductlink::where('product_id', $id)->where('user_id', $userid)->first();
                
                return view('user.products.productedit', compact('products'));
            }
            
            return redirect()->back();
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required',
            'value' => 'required',
            'sellingprice' => 'required',
        ]);
        $id=$request->productid;
        $userproducts = Userproduct::find($id);
        $userproducts->title = $request->get('title');
        $userproducts->author = $request->get('author');       
        $userproducts->stock = $request->get('stock');
        $userproducts->original_price = $request->get('value');
        $userproducts->selling_price = $request->get('sellingprice');
        $userproducts->update();
        $notification = array(
            'message' => '"'.$userproducts->title.'" Updated Successfully!!', 
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function updatePublicStatus(Request $request)
    {
        $request->validate([
            'productid' => 'required',
            'public_status' => 'required',
        ]);
        $id=$request->productid;
        $userproducts = Userproduct::find($id);
        $userproducts->check_public = $request->get('public_status');
        $userproducts->update();
        if ($request->get('public_status')==1) {
            $status='public (Everyone can see)';
        }
        else{
            $status='private (only you can see) ';
        }
        $notification = array(
            'message' => '"'.$userproducts->title.'" is now '.$status, 
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $userid = Auth::id();
        if ($userid == Userproduct::where('id', $id)->value('user_id')) {
            Userproduct::where('id', $id)->update(['delete_status' => 1]);
            $products = Userproduct::where('id', $id)->first();
            /**$photo1 = $products->photo1;
            $imagename = 'images/' . $photo1;
            $thumbnailname = 'thumbnails/' . $photo1;
            if(Storage::disk('public')->exists($imagename)){
                
                Storage::disk('public')->delete($imagename);
                Storage::disk('public')->delete($thumbnailname);
               
            }
            $products->delete();**/
            $notification = array(
                'message' => '"'.$products->title.'" has been deleted successfully', 
                'alert-type' => 'success'
            );
            
        
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'something went wrong', 
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
