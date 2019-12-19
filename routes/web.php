<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'Home\HomeController@index')->name('/');
Route::get('/search', 'Home\SearchController@searchinput')->where(['query' => '[a-z\d-\/_.]+'])->name('search');
Route::get('/{username}', 'User\UserStoreController@userstore')->name('userstore');
Route::get('notification', 'Home\HomeController@notification');

Route::get('autocomplete', 'Home\SearchController@autocomplete')->name('autocomplete');
Route::post('autocomplete', 'Home\SearchController@autocomplete')->name('autocomplete');
Route::get('/p/{slug}', 'Home\HomeController@productshow')->where(['slug' => '[a-z\d-\/_.]+'])->name('userproduct.slug');
Route::prefix('go')->group(function () {
    Route::get('/cart', 'Home\CartController@index')->name('cart.index');
    
    Route::post('/cart/add', 'Home\CartController@additem')->name('cart.additem');
    Route::get('/cart/update/{itemId}/{quantity}', 'Home\CartController@update')->name('cart.update');
    Route::get('/cart/remove/{itemId}', 'Home\CartController@removeitem')->name('cart.removeitem');
    Route::post('/cart/switchToSaveForLater/{product}', 'Home\SaveForLaterController@switchToSaveForLater')->name('cart.switchToSaveForLater');
    Route::delete('/saveForLater/{product}', 'Home\SaveForLaterController@destroy')->name('saveForLater.destroy');
    Route::post('/saveForLater/switchToCart/{product}', 'Home\SaveForLaterController@switchToCart')->name('saveForLater.switchToCart');

    Route::get('/wishlist', 'Home\WishlistController@index')->name('wishlist.index');
    Route::post('/wishlist', 'Home\WishlistController@add')->name('wishlist.add');
    Route::post('/wishlist/movetocart', 'Home\WishlistController@MoveToCart')->name('wishlist.move2cart');
    Route::post('/wishlist/{id}', 'Home\WishlistController@delete')->name('wishlist.delete');

    Route::get('/checkout', 'Home\CheckoutController@index')->name('checkout.index');
    Route::get('/checkout/delete/addressid={address_id}', 'Home\CheckoutController@deleteAddress')->name('checkout.address.delete');
    Route::get('/thankyou', 'Home\CheckoutController@thankyou')->name('checkout.thankyou');
    Route::post('/placeorder', 'Home\CheckoutController@placeOrder')->name('checkout.placeorder');
    Route::get('/placeorder/addressid={address_id}', 'Home\CheckoutController@placeOrderWithSavedAddress')->name('checkout.placeorderwitha');
});
Route::prefix('user')->group(function () {

    Auth::routes();

    Route::get('/dashboard', 'User\UserController@index')->name('dashboard');
    Route::get('/profile', 'User\UserController@showprofile')->name('profile');
    Route::get('/myaddress', 'User\UserController@showaddress')->name('myaddress');
    Route::get('/myaddress/delete/{address_id}', 'User\UserController@deleteAddress')->name('myaddress.delete');
    Route::get('/passbook', 'User\PassbookController@index')->name('passbook');
    Route::get('/myorder', 'User\myorderController@allorder')->name('myorder.all');
    Route::get('/myorder/buy', 'User\myorderController@allbuyorder')->name('myorder.allbuy');
    Route::get('/myorder/buy/{order}', 'User\myorderController@onebuyorder')->name('myorder.onebuyorder');
    
//product adding

    Route::get('/sell', 'User\SellController@index')->name('sell');
    Route::get('/sell/add2/{productid}', 'User\SellController@AddUsersProduct')->name('sell.AddUsersProduct');
    Route::get('/sell/add', 'User\SellController@addproduct')->name('sell.add');
    Route::post('/sell/store', 'User\SellController@store')->name('sell.store');
    Route::get('/sell/edit/', function () {return redirect('user/sell');});
    Route::post('/sell/edit/', 'User\SellController@edit')->name('sell.edit');
    Route::get('/sell/delete/{id}', 'User\SellController@destroy')->name('sell.delete');
    Route::get('/sell/linkedproductdelete/{id}', 'User\SellController@deleteLinkedProduct')->name('sell.deletelinkedproduct');
    Route::get('/sell/update', function () {return redirect('user/sell');});
    Route::post('/sell/linkedupdate', 'User\SellController@linkedProductUpdate')->name('sell.linkedupdate');
    Route::get('/sell/update', function () {return redirect('user/sell');});
    Route::post('/sell/update', 'User\SellController@update')->name('sell.update');
    
    Route::get('/sell/updatelinkedpublic', function () {return redirect('user/sell');});
    Route::post('/sell/updatelinkedpublic', 'User\SellController@updateLinkedPublicStatus')->name('sell.updateLinkedPublic');
    Route::get('/sell/updatepublic', function () {return redirect('user/sell');});
    Route::post('/sell/updatepublic', 'User\SellController@updatePublicStatus')->name('sell.updatePublic');
    
    Route::get('/update/storename/', 'User\UserController@updateStoreShow')->name('username.update.show');
    Route::post('/update/storename/', 'User\UserController@updateStorename')->name('username.update');
    Route::post('/update/storename/check', 'User\UserController@updateStorenamecheck')->name('username.check');
});
