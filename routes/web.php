<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pengacara\PengacaraController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login',                         [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register/member',              [AuthController::class, 'showRegisterMember'])->name('showRegisterMember');
Route::get('/register/pengacara',           [AuthController::class, 'showRegisterPengacara'])->name('showRegisterPengacara');
Route::get('/verify-email',                 [AuthController::class, 'verifyEmail'])->name('verify.email');



Route::get('/search',                       [PengacaraController::class, 'search'])->name('search');
Route::get('/pengacara',                    [PengacaraController::class, 'showIndex'])->name('showIndex');
Route::post('submit-form-daftar',           [AuthController::class, 'submitFormDaftar'])->name('submitFormDaftar');
Route::post('/register/member',             [AuthController::class, 'registerMember'])->name('registerMember');

// getData
    Route::get('/provinces',                [AuthController::class, 'getProvinces'])->name('getProvinces');
    Route::get('/regencies',                [AuthController::class, 'getRegencies'])->name('getRegencies');
    Route::get('/districts',                [AuthController::class, 'getDistricts'])->name('getDistricts');
    Route::get('/villages',                 [AuthController::class, 'getVillages'])->name('getVillages');
//! getData