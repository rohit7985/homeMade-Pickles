<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\RatingReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/user/registration', function () {
    return view('registration');
})->name('view.registration');

Route::get('/login',[shopController::class,'viewLogin'])->name('login.view');



Route::get('/shop',[shopController::class,'index'])->name('shop');
Route::get('/product/{product}/details',[shopController::class,'productDetails'])->name('product.details');


Route::post('/user/create', [UserController::class, 'createUser'])->name('users.create');
Route::post('/user/login', [UserController::class, 'login'])->name('user.login');
Route::post('/user/verify-otp', [UserController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/user/resend-otp/{userId}', [UserController::class, 'resendOTP'])->name('resend.otp');





Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login.admin');
Route::post('/loginData', [LoginController::class, 'adminLogin'])->name('admin.login');


Route::middleware('auth.user')->prefix('customer')->group(function () {
    Route::get('/cart',[CartController::class,'showUserCart'])->name('customer.cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{item}', [CartController::class, 'delete'])->name('cartItem.delete');
    Route::post('/updateQuantity', [ProductController::class, 'updateQuantity'])->name('update.quantity');



    Route::get('/myProfile', [CustomerProfileController::class, 'myProfile'])->name('user.myProfile');
    Route::get('/myOrder', [CustomerProfileController::class, 'myOrder'])->name('customer.myOrder');
    Route::post('/myOrder/store', [CustomerOrderController::class, 'store'])->name('complete.customerOrder');

    Route::post('/rating/store', [RatingReviewController::class, 'store'])->name('rating.store');


    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

    Route::get('/address', [AddressController::class, 'viewAddress'])->name('customer.address');
    Route::post('/addresses', [AddressController::class, 'store'])->name('address.store');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::get('/edit-address/{id}', [AddressController::class, 'editAddress'])->name('edit.address');
    Route::post('/address/update', [AddressController::class, 'update'])->name('address.update');





});


Route::middleware('auth:admin')->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');

    Route::get('/registration', function () {
        return view('admin.register');
    });

    Route::get('/add-product', function () {
        return view('admin.addProduct');
    })->name('admin.addProduct');

    Route::post('/products/toggle-hidden/{id}', [ProductController::class, 'toggleHiddenStatus'])->name('admin.toggleHiddenStatus');
    Route::post('/updateQuantity', [ProductController::class, 'updateQuantity'])->name('update.quantity');


    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::post('/register', [LoginController::class, 'register'])->name('admin.register');

    Route::get('/products',[ProductController::class, 'index'])->name('admin.products');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{editProduct}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');

    Route::get('/customers',[UserController::class, 'viewCustomers'])->name('admin.view.customers');
    Route::post('/user/create', [UserController::class, 'createUser'])->name('admin.user.create');
    Route::delete('/customer/{customer}', [UserController::class, 'destroy'])->name('customer.destroy');
    Route::patch('/customer/update/{id}', [AdminController::class, 'updateStatus']);
    Route::any('/filter/customer', [AdminController::class, 'filter'])->name('filter.customer');

    Route::get('/customer/{id}', [UserController::class, 'showUserDetails'])->name('customer.details');









});

