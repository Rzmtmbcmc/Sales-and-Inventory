<?php

use App\Models\User;
use App\Http\Controllers\login;
use App\Http\Controllers\signup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Api\DashboardController;

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
Route::get('root',function(){
    return view('index');
})->name('root');
Route::get('/', function () {
    if (!User::where('email','Owner@example.com')->exists()) {
        User::create([
        'name' => 'Owner',
        'email' => 'Owner@example.com',
        'password' => bcrypt('12345678'),
        'Role' => 'Owner',
    ]);
    }
    return view('index');
});
//routes: login, signup, logout
Route::get('signup',[signup::class,'showForm'])->name('Signup');
Route::get('login', [login::class,'showForm'])->name('Login');
Route::post('login', [login::class,'loginUser'])->name('loginUser');
Route::post('logout', [login::class,'logout'])->name('logout');
Route::post('signup',[signup::class,'createUser'])->name('createUser');
// Password Reset Routes...
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/update', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
//routes: dashboard
Route::get('customer',[MainController::class,'customer'])->name('customer');
Route::get('manager',[MainController::class,'manager'])->name('manager');
Route::get('owner',[MainController::class,'owner'])->name('owner');
Route::get('owner/dashboard', [DashboardController::class, 'showView'])->name('owner.dashboard');
Route::get('api/analytics', [DashboardController::class, 'analytics']);
//routes: change password
Route::get('owner/change-password',[MainController::class,'ownerChangePassword'])->name('owner.password.edit');
Route::put('change-password',[MainController::class,'ownerUpdatePassword'])->name('owner.password.update');
Route::get('manager/change-password',[MainController::class,'managerChangePassword'])->name('manager.password.edit');

//routes: products
Route::get('owner/products',[ProductController::class,'showView'])->name('owner.products');
//Route::post('owner/products',[ProductController::class,'addProduct'])->name('owner.products.add');

//routes: brand
Route::get('/owner/brand',[BrandController::class,'showView'])->name('owner.brands');

//route: order
Route::get('owner/orders',[OrderController::class,'showView'])->name('owner.orders');
Route::post('/api/orders/deduct-inventory', [OrderController::class, 'deductInventory'])->name('owner.orders.deduct-inventory');


Route::get('api/brands', [BrandController::class, 'index']);
Route::get('api/branches', [BranchController::class, 'allBranches']);
Route::get('api/products', [ProductController::class, 'index']);

//route Manager Accounts
Route::get('owner/managers',[ManagerController::class,'showView'])->name('owner.managers');