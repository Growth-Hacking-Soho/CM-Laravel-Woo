<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GiftController;
use App\Mail\ThanksMail;
use App\Models\Gift;
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
Route::get('/gift/index/{uuid}', function ($uuid) {
    $gift = Gift::where('key','=', $uuid)->get()->first();
    if ($gift == null){
        return view('customer.gifts.error');
    }

    $model = new \stdClass();
    $model->name = $gift->name;
    $model->message = $gift->message;
    $model->email = $gift->email;
    $model->phone = $gift->phone;
    $model->key = $gift->key;

    app('debugbar')->debug($model);

    return view('customer.gifts.index')
    ->with(['uuid' => $uuid, 'model' => $model]);
});
Route::get('/gift/show/{key}', [GiftController::class, 'showUpdate'])->name('gift.showUpdate');
Route::post('/gift', [GiftController::class, 'store'])->name('gift.store');
Route::post('/gift/{key}', [GiftController::class, 'update'])->name('gift.update');

Route::get('/admin/debug', [AdminController::class, 'debug'])->name('admin.debug');

Route::get('/gift/play/{id}', [GiftController::class, 'play'])->name('gift.play');
Route::get('/gift/preview/{id}', [GiftController::class, 'preview'])->name('gift.preview');
Route::get('/video/{id}', [GiftController::class, 'video'])->name('gift.video');
Route::get('/media/{id}', [GiftController::class, 'media'])->name('gift.media');

//send-mail
Route::get('/gifts/send/{key}', function ($key) {

    /* $details = [
        'title' => 'Titulo del correo',
        'body' => 'Cuerpo del email'
    ]; */

    Mail::to("jspinzonr@gmail.com")->send(new ThanksMail($key));

    //dd("Email enviado");

    return view('customer.gifts.send')
    ->with('key', $key);
});
