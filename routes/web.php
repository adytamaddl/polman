<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\QrisController;
use App\Http\Controllers\RiwayatController;

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
Route::middleware(['auth'])->group(function(){

    Route::get('/', function () {
        return view('home');
    
    })->name('home');
    Route::get('/status/{id}', [QrisController::class, 'status']);
    Route::POST('/qris', [TokenController::class, 'qris']);
    Route::get('/modal', function() {
        return view('modal');
    })->name('index');
    Route::get('/coba', [QrisController::class, 'enkripsi']);

});


Auth::routes();
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/riwayat', [RiwayatController::class, 'riwayat'])->name('riwayat');