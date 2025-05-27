<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 07-11-2021
 *
 * @modified 19-12-2021
 */

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// homepage
Route::group(['middleware' => ['locale']], function () {
    Route::get('/', 'SiteController@index')->name('site.index');
    Route::post('review/pagination/fetch', 'SiteController@fetch')->name('fetch.review');
    Route::post('change-language', 'DashboardController@switchLanguage')->middleware(['checkForDemoMode']);

    Route::get('shop/{alias}', 'SellerController@index')->name('site.shop');
    Route::get('shop/profile/{alias}', 'SellerController@vendorProfile')->name('site.shop.profile');

    Route::get('auth', [LoginController::class, 'showLoginForm']);
    Route::get('auth/login', [LoginController::class, 'showLoginForm'])->name('login');

    // login register
    Route::get('login', 'LoginController@login');
    Route::get('user/login', 'LoginController@login')->name('site.login');
    Route::post('authenticate', 'LoginController@authenticate')->name('site.authenticate');
    Route::get('user-verify/{token}/{from?}', 'LoginController@verification')->name('site.verify');
    Route::get('user-verification/{otp}', 'LoginController@verifyByOtp');
    Route::post('sign-up-store', 'LoginController@signUp')->name('site.signUpStore');
    Route::get('myaccount/logout', 'LoginController@logout')->name('site.logout');
    Route::get('check-email-existence/{email}', 'LoginController@checkEmailExistence');
    Route::get('sign-up-email', 'LoginController@emailSignup')->name('site.emailSignup');
    Route::post('sign-up-email/store', 'LoginController@emailStore')->name('site.emailStore');
    Route::post('resend-verification-code', 'LoginController@resendUserVerificationCode');

    // Password reset
    Route::get('password/resets/{token}', 'LoginController@showResetForm')->name('site.password.reset');
    Route::post('password/resets', 'LoginController@setPassword')->name('site.password.resets');
    Route::post('password/email', 'LoginController@sendResetLinkEmail')->name('site.login.sendResetLink');
    Route::get('password/reset-otp/{token}', 'LoginController@resetOtp')->name('site.reset.otp');
    Route::get('verification/otp', 'LoginController@verificationOtp')->name('site.verification.otp');
    // Check valid mail
    Route::get('valid-mail/{mail}', 'LoginController@validMail')->name('site.valid_mail');

    // Seller register
    Route::get('seller/sign-up', 'RegisteredSellerController@showSignUpForm')->name('site.seller.signUp');
    Route::post('seller/sign-up-store', 'RegisteredSellerController@signUp')->name('site.seller.signUpStore');
    Route::get('seller/otp', 'RegisteredSellerController@otpForm')->name('site.seller.otp');
    Route::get('seller/resend-otp/{email?}', 'RegisteredSellerController@resendVerificationCode')->name('site.seller.resend-otp');
    Route::get('seller-verify/{token}', 'RegisteredSellerController@verification')->name('site.seller.verify');
    Route::post('seller-verify/otp', 'RegisteredSellerController@otpVerification')->name('site.seller.otpVerify');

    // Review
    Route::post('site/review/filter', 'SiteController@filterReview');
    Route::post('site/review/search', 'SellerController@searchReview');

    // product
    Route::get('products/{slug}', 'SiteController@productDetails')->name('site.productDetails');

    // Blog
    Route::get('blogs/{value?}', 'SiteController@allBlogs')->name('blog.all');
    Route::get('blog/search', 'SiteController@blogSearch')->name('blog.search');
    Route::get('blog/details/{slug}', 'SiteController@blogDetails')->name('blog.details');
    Route::get('blog-category/{id}', 'SiteController@blogCategory')->name('blog.category');

    // Brands
    Route::get('brand/{id}/products', 'SiteController@brandProducts')->name('site.brandProducts');

    // cart
    Route::get('carts', 'CartController@index')->name('site.cart');
    Route::post('cart-store', 'CartController@store')->name('site.addCart');
    Route::post('cart-reduce-qty', 'CartController@reduceQuantity')->name('site.cartReduceQuantity');
    Route::post('cart-delete', 'CartController@destroy')->name('site.delete');
    Route::post('cart-selected-delete', 'CartController@destroySelected');
    Route::post('cart-selected-store', 'CartController@storeSelected');
    Route::post('cart-all-delete', 'CartController@destroyAll');
    Route::post('cart-select-shipping', 'CartController@selectShipping');

    // Order
    Route::post('order', 'OrderController@store')->middleware(['checkGuest'])->name('site.orderStore');
    Route::get('order-confirm/{reference}', 'OrderController@confirmation')->name('site.orderConfirm');
    Route::get('order-paid', 'OrderController@orderPaid')->name('site.orderpaid');
    Route::post('order-get-shipping-tax', 'OrderController@getShippingTax')->name('site.orderTaxShipping');

    // Check Out
    Route::get('checkout', 'OrderController@checkOut')->middleware(['checkGuest'])->name('site.checkOut');

    // check coupon
    Route::post('check-coupon', 'CartController@checkCoupon')->name('site.checkCoupon');
    Route::post('delete-coupon', 'CartController@deleteCoupon')->name('site.deleteCoupon');

    // search
    Route::get('search-products', 'SiteController@search')->name('site.productSearch');

    // userSearch
    Route::post('get-search-data', 'SiteController@getSearchData')->name('site.searchData');

    // compare
    Route::get('/compare', 'CompareController@index')->name('site.compare');
    Route::post('/compare-store', 'CompareController@store')->name('site.addCompare');
    Route::post('/compare-delete', 'CompareController@destroy')->name('site.compareDestroy');

    // Track order
    Route::get('/track-order', 'OrderController@track')->name('site.trackOrder');

    // Quick View
    Route::get('product/quick-view/{id}', 'SiteController@quickView')->name('quickView');

    // coupon
    Route::get('/coupon', 'SiteController@coupon')->name('site.coupon');

    // shipping
    Route::get('/get-shipping', 'SiteController@getShipping');

    //downloadable link
    Route::get('/download', 'SiteController@download')->name('site.downloadProduct');

    // Pages
    Route::get('page/{slug}', 'SiteController@page')->name('site.page');

    Route::get('/get-component-product', 'SiteController@getComponentProduct')->name('ajax-product');

    //all categories
    Route::get('/categories', 'SiteController@allCategories')->name('all.categories');

    // payment link
    Route::get('/order/payment/{reference}', 'SiteController@orderPayment')->name('site.order.custom.payment');
});

// login or register by google
Route::get('login/google', 'LoginController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'LoginController@handelGoogleCallback')->name('google');

// login or register by facebook
Route::get('login/facebook', 'LoginController@redirectToFacebook')->name('login.facebook');
Route::get('login/facebook/callback', 'LoginController@handelFacebookCallback')->name('facebook');

Route::group(['middleware' => ['site.auth', 'locale', 'permission']], function () {
    Route::post('/site/review/destroy', 'SiteController@deleteReview');
    Route::post('/site/review/update', 'SiteController@updateReview');
    // be a seller request
    Route::post('/seller/request-store', 'RegisteredSellerController@sellerRequestStore')->name('seller.store.request');
});

Route::get('/reset-data', 'ResetDataController@reset');

Route::get('guest/payment/{reference}', 'OrderController@payment')->name('site.order.payment.guest');
Route::get('guest/order-paid', 'OrderController@orderPaid')->name('site.orderpaid.guest');
Route::get('guest/order-confirm/{reference}', 'OrderController@confirmation')->name('site.orderConfirm.guest');
Route::get('guest/invoice/print/{id}', 'OrderController@invoicePrint')->name('site.invoice.print.guest');

Route::get('shipping/provider/{id}', 'ShippingProviderController@shippingProvider')->name('shipping.provider');
Route::get('find-shipping-providers', 'ShippingProviderController@findShippingProviders')->name('find.shipping.providers');
Route::group(['prefix' => 'myaccount', 'as' => 'site.', 'middleware' => ['site.auth', 'locale', 'permission']], function () {
    Route::get('overview', 'DashboardController@index')->name('dashboard');
    Route::get('wishlists', 'WishlistController@index')->name('wishlist');
    Route::get('reviews', 'ReviewController@index')->name('review');
    Route::get('profile', 'UserController@edit')->name('userProfile');
    Route::get('setting', 'UserController@setting')->name('userSetting');
    Route::get('activity', 'UserController@activity')->name('userActivity');
    Route::get('downloads', 'DownloadController@index')->name('download');
    Route::get('addresses', 'AddressController@index')->name('address');
    Route::get('address/create', 'AddressController@create')->name('addressCreate');
    Route::get('address/edit/{id}', 'AddressController@edit')->name('addressEdit');
    Route::get('orders', 'OrderController@index')->name('order');
    Route::get('orders/{reference}', 'OrderController@orderDetails')->name('orderDetails');
    Route::get('notifications', 'NotificationController@index')->name('notifications.index');

    // user
    Route::post('profile/update', 'UserController@update')->name('profile.update');
    Route::post('profile/update-password', 'UserController@updatePassword')->name('password.update');
    Route::post('delete', 'UserController@destroy')->name('user.delete');
    Route::get('profile/remove-image', 'UserController@removeImage')->name('profile.delete');
    Route::get('invoice/print/{id}', 'OrderController@invoicePrint')->name('invoice.print');

    // Wishlist
    Route::post('wishlist/store', 'WishlistController@store')->name('wishlist.store');

    // Address
    Route::post('address/store', 'AddressController@store')->name('address.store');
    Route::post('address/update/{id}', 'AddressController@update')->name('address.update');
    Route::post('address/delete/{id}', 'AddressController@destroy')->name('address.delete');
    Route::post('check-default-address', 'AddressController@checkDefault');
    Route::get('make-default-address/{id}', 'AddressController@makeDefault')->name('address.set.default');

    // review
    Route::post('review-store', 'SiteController@reviewStore')->name('review.store');
    Route::post('review/delete/{id}', 'ReviewController@destroy')->name('review.destroy');

    // Notifications
    Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
    Route::patch('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_read');
    Route::patch('notifications/mark-as-unread/{id}', 'NotificationController@markAsUnread')->name('notifications.mark_unread');
    Route::get('notifications/view/{id}', 'NotificationController@view')->name('notifications.view');
});

Route::get('products', 'ProductController@search')->name('site.product.search');
