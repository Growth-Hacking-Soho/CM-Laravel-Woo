<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GiftController;
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

Route::get('/gift/{id}', [GiftController::class, 'show'])->name('gift.show');
Route::post('/gift', [GiftController::class, 'store'])->name('gift.store');

Route::get('/admin/debug', [AdminController::class, 'debug'])->name('admin.debug');

Route::get('/gift/play/{id}', [GiftController::class, 'play'])->name('gift.play');
Route::get('/video/{id}', [GiftController::class, 'video'])->name('gift.video');

Route::get('send-mail', function () {

    $details = [
        'title' => 'Titulo del correo',
        'body' => 'Cuerpo del email'
    ];

    \Mail::to('your_receiver_email@gmail.com')->send(new \App\Mail\ThanksMail($details));

    dd("Email enviado");
});
