<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GiftController;
use App\Mail\ThanksMail;
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

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/admin/orders', [GiftController::class, 'index'])->name('gift.index');

Route::get('/gift/{id}', [GiftController::class, 'show'])->name('gift.show');
Route::get('/gift/show/{key}', [GiftController::class, 'showUpdate'])->name('gift.showUpdate');
Route::post('/gift', [GiftController::class, 'store'])->name('gift.store');
Route::post('/gift/{key}', [GiftController::class, 'update'])->name('gift.update');

Route::get('/admin/debug', [AdminController::class, 'debug'])->name('admin.debug');

Route::get('/gift/play/{id}', [GiftController::class, 'play'])->name('gift.play');
Route::get('/gift/preview/{id}', [GiftController::class, 'preview'])->name('gift.preview');
Route::get('/video/{id}', [GiftController::class, 'video'])->name('gift.video');

//send-mail
Route::get('/gifts/send/{key}', function ($key) {

    /* $details = [
        'title' => 'Titulo del correo',
        'body' => 'Cuerpo del email'
    ]; */

    Mail::to("jspinzonr@gmail.com")->send(new ThanksMail($key));

    //dd("Email enviado");

    return view('customer.gifts.send');
});
