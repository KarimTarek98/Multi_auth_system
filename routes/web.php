<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {

    Route::controller(AdminController::class)->group(function () {

        Route::get('/login', 'loginPage')->name('login_form');
        Route::post('/login', 'login')->name('admin.login');
        Route::get('/dashboard', 'dashboardPage')->name('admin.dashboard')
        ->middleware('admin');
        Route::get('/logout', 'logout')->name('admin.logout')->middleware('admin');

        Route::get('/register', 'register')->name('admin.register');
        Route::post('/register', 'store')->name('store.admin');
    });

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
