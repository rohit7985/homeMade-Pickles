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
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\RatingReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Merchants\MerchantCategoryController;
use App\Http\Controllers\Merchants\MerchantController;
use App\Http\Controllers\Merchants\MerchantOrderController;
use App\Http\Controllers\Merchants\MerchantProductController;
use App\Http\Controllers\Merchants\MerchantRegistrationController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\WishlistController;

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

Route::get('/about-us', function () {
    return view('about');
})->name('about');

Route::get('/FAQ', function () {
    return view('faq');
})->name('faq');

Route::get('/user/registration', function () {
    return view('registration');
})->name('view.registration');

Route::get('/login', [shopController::class, 'viewLogin'])->name('login.view');
Route::get('/privacy/policy', [PolicyController::class, 'privacy'])->name('privacy');



Route::get('/shop', [shopController::class, 'index'])->name('shop');
Route::get('/filter/category/{category}', [shopController::class, 'filterByCategory'])->name('filter.category');
Route::post('/filter-by-price', [shopController::class, 'filterByPrice'])->name('filter.by.price');




Route::post('/productSearch', [ProductController::class, 'productSearch'])->name('productSearch');
Route::post('/search/product', [ProductController::class, 'search'])->name('search.product');
Route::get('/product/{product}/details', [shopController::class, 'productDetails'])->name('product.details');


Route::post('/user/create', [UserController::class, 'createUser'])->name('users.create');
Route::post('/user/login', [UserController::class, 'login'])->name('user.login');
Route::post('/user/verify-otp', [UserController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/user/resend-otp/{userId}', [UserController::class, 'resendOTP'])->name('resend.otp');

Route::post('/send-reset-password-link', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('send.resetPasswordLink');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');




Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login.admin');
Route::post('/login/data', [LoginController::class, 'adminLogin'])->name('admin.login');

Route::middleware('auth.user')->prefix('customer')->group(function () {
    Route::get('/cart', [CartController::class, 'showUserCart'])->name('customer.cart');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{item}', [CartController::class, 'delete'])->name('cartItem.delete');
    Route::post('/updateQuantity', [ProductController::class, 'updateQuantity'])->name('update.quantity');

    Route::delete('/wishlist/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist');

    Route::get('/myProfile', [CustomerProfileController::class, 'myProfile'])->name('user.myProfile');
    Route::post('/add/contact', [CustomerProfileController::class, 'addContact'])->name('add.contact');

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

    // Route::get('/dashboard', function () {
    //     return view('admin.index');
    // })->name('admin.dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/myProfile', [AdminController::class, 'myProfile'])->name('admin.myProfile');
    Route::post('/change-email', [AdminController::class, 'changeEmail'])->name('change.email');



    Route::get('/registration', function () {
        return view('admin.register');
    });

    Route::get('/add-product', [ProductController::class, 'addProduct'])->name('admin.addProduct');
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('get-subcategories');



    Route::get('/view/categories', [CategoryController::class, 'index'])->name('admin.view.categories');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete-category');
    Route::patch('/update-category', [CategoryController::class, 'updateCategory'])->name('admin.category.update');

    Route::get('/view/subCategories', [SubCategoryController::class, 'index'])->name('admin.view.subCategory');
    Route::post('/subCategories/store', [SubCategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::delete('/delete-subcategory/{id}', [SubCategoryController::class, 'deleteSubCategory'])->name('delete-subcategory');

    Route::post('/update-subcategory', [SubCategoryController::class, 'updateSubCategory'])->name('admin.subcategory.update');







    Route::post('/products/toggle-hidden/{id}', [ProductController::class, 'toggleHiddenStatus'])->name('admin.toggleHiddenStatus');
    Route::post('/product/updateQuantity', [ProductController::class, 'updateQuantity'])->name('update.productQuantity');


    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::post('/register', [LoginController::class, 'register'])->name('admin.register');

    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::any('/filter/orders', [OrderController::class, 'filterOrders'])->name('filter.order');
    Route::get('/order/mark-completed/{id}', [OrderController::class, 'markCompleted'])->name('admin.order.markCompleted');


    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{editProduct}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
    Route::post('/search/product', [OrderController::class, 'searchProduct'])->name('search.products');
    Route::any('/products/filter', [AdminController::class, 'filterProducts'])->name('filter.products');




    Route::get('/customers', [UserController::class, 'viewCustomers'])->name('admin.view.customers');
    Route::post('/user/create', [UserController::class, 'createUser'])->name('admin.user.create');
    Route::delete('/customer/{customer}', [UserController::class, 'destroy'])->name('customer.destroy');
    Route::patch('/customer/update/{id}', [AdminController::class, 'updateStatus']);
    Route::any('/filter/customer', [AdminController::class, 'filter'])->name('filter.customer');
    Route::post('/customer/approve', [AdminController::class, 'approveSelectedCustomers'])->name('admin.customer.approve');
    // routes/web.php

    Route::get('/customer/approve-all-pending', [AdminController::class, 'approveAllPending'])->name('admin.approveAllPending');



    Route::get('/customer/{id}', [UserController::class, 'showUserDetails'])->name('customer.details');
    Route::post('/search/user', [UserController::class, 'searchUser'])->name('search.user');

    Route::get('/merchants', [MerchantController::class, 'viewMerchants'])->name('admin.view.merchants');
});

Route::get('/merchant/registration', function () {
    return view('merchant.register');
})->name('merchant.registration');
Route::get('/merchant/setPassword/{email}', [MerchantRegistrationController::class, 'showSetPasswordForm'])->name('merchant.setPassword');
Route::get('/merchant/login/viaGoogle', [MerchantRegistrationController::class, 'loginViaGoogle'])->name('merchantLogin.via.google');
Route::get('/auth/google/callback', [MerchantRegistrationController::class, 'googleHandle'])->name('merchantLogin.handleForm');
Route::get('/merchant/login', function () {
    return view('merchant.login');
})->name('login.merchant');

Route::post('/registration/store', [MerchantRegistrationController::class, 'register'])->name('merchant.register');
Route::post('/registration/save', [MerchantRegistrationController::class, 'registerViaGoogle'])->name('merchant.register.viaGoogle');
Route::post('/loginData', [MerchantController::class, 'merchantLogin'])->name('merchant.login');
Route::post('/merchant/save', [MerchantRegistrationController::class, 'savePassword'])->name('merchant.save');


// Merchant dashboard route
Route::middleware('auth:merchant')->prefix('merchant')->group(function () {
    Route::get('/dashboard', [MerchantController::class, 'index'])->name('merchant.dashboard');
    Route::get('/logout', [MerchantController::class, 'logout'])->name('merchant.logout');

    Route::get('/products', [MerchantController::class, 'viewProduct'])->name('merchant.products');
    Route::get('/add-product', [MerchantProductController::class, 'addProduct'])->name('merchant.addProduct');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

    Route::get('/get-subcategories/{categoryId}', [MerchantProductController::class, 'getSubcategories'])->name('get-subcategories');
    Route::get('/products/{editProduct}/edit', [MerchantProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}/update', [MerchantProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [MerchantProductController::class, 'destroy'])->name('products.destroy');
    Route::any('/products/filter', [MerchantProductController::class, 'filterProducts'])->name('filter.products');
    Route::post('/products/toggle-hidden/{id}', [MerchantProductController::class, 'toggleHiddenStatus'])->name('merchant.toggleHiddenStatus');
    Route::post('/updateQuantity', [MerchantProductController::class, 'updateQuantity'])->name('update.quantity');
 


    Route::get('/orders', [MerchantOrderController::class, 'index'])->name('merchant.orders');
    Route::get('/order/mark-completed/{id}', [MerchantOrderController::class, 'markCompleted'])->name('merchant.order.markCompleted');
    Route::any('/filter/orders', [MerchantOrderController::class, 'filterOrders'])->name('filter.order');
    Route::get('/orders/{order}', [MerchantOrderController::class, 'cancelledOrder'])->name('order.cancel');



    Route::get('/view/categories', [CategoryController::class, 'index'])->name('merchant.view.categories');


    Route::get('/view/subCategories', [MerchantCategoryController::class, 'viewSubCategory'])->name('merchant.view.subCategory');
    Route::post('/subCategories/store', [SubCategoryController::class, 'store'])->name('merchant.subcategory.store');

    Route::get('/myProfile', [MerchantController::class, 'myProfile'])->name('merchant.myProfile');
    Route::post('/change/personal-data', [MerchantController::class, 'changeData'])->name('change.personalData');
    Route::post('/change-bankDetails', [MerchantController::class, 'changeBankDetails'])->name('change.bankDetails');



});
