<?php

use App\Http\Controllers\login;
use App\Http\Controllers\signup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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
    return view('index');
});
Route::get('signup',[signup::class,'showForm'])->name('Signup');

Route::get('login', [login::class,'showForm'])->name('Login');
Route::post('login', [login::class,'loginUser'])->name('loginUser');

Route::get('logout', [login::class,'logout'])->name('logout');

Route::post('signup',[signup::class,'createUser'])->name('createUser');

Route::get('customer',[MainController::class,'customer'])->name('customer');
Route::get('manager',[MainController::class,'manager'])->name('manager');
Route::get('owner',[MainController::class,'owner'])->name('owner');
