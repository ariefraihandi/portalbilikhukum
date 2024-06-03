<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\SidebarMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Pengacara\PengacaraController;

Route::get('/', function () {
    return redirect('https://bilikhukum.com');
});

Route::get('/login',                         [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',                        [AuthController::class, 'login'])->name('submitLogin');
Route::get('/logout',                        [AuthController::class, 'logout'])->name('logout');

Route::middleware([AuthMiddleware::class, SidebarMiddleware::class])->group(function () {
    Route::get('/dashboard',                [DashboardController::class, 'showDashboard'])->name('showDashboard');
    Route::get('/menu',                     [MenuController::class, 'showMenu'])->name('showMenu');
    Route::get('/submenu',                  [MenuController::class, 'showsubMenu'])->name('showsubMenu');

    //Get Data
        Route::get('/getdata/menu',                  [MenuController::class, 'getDataMenu'])->name('getDataMenu');
        Route::get('/getdata/submenu',               [MenuController::class, 'getDatasubMenu'])->name('getDatasubMenu');
    //Get Data

});

Route::get('/register',                     [AuthController::class, 'showRegister'])->name('showRegister');
Route::get('/register/member',              [AuthController::class, 'showRegisterMember'])->name('showRegisterMember');
Route::get('/register/pengacara',           [AuthController::class, 'showRegisterPengacara'])->name('showRegisterPengacara');
Route::get('/register/mediator',            [AuthController::class, 'showRegisterPengacara'])->name('showRegisterMediator');
Route::get('/verify-email',                 [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('submit-form-daftar',           [AuthController::class, 'submitFormDaftar'])->name('submitFormDaftar');
Route::post('/register/member',             [AuthController::class, 'registerMember'])->name('registerMember');

Route::get('/search',                       [PengacaraController::class, 'search'])->name('search');
Route::get('/pengacara',                    [PengacaraController::class, 'showIndex'])->name('showIndex');
Route::get('/pengacara',                    [PengacaraController::class, 'showIndex'])->name('showIndex');

Route::get('/role',                         [RoleController::class, 'showRole'])->name('showRole');
Route::post('/role',                        [RoleController::class, 'rolesStore'])->name('roles.store');

// Route::get('/menu',                         [MenuController::class, 'showMenu'])->name('showMenu');
Route::post('/menu',                        [MenuController::class, 'addMenu'])->name('add.menu');
Route::get('/getdata/menu',                  [MenuController::class, 'getDataMenu'])->name('getDataMenu');
Route::get('/getdata/submenu',               [MenuController::class, 'getDatasubMenu'])->name('getDatasubMenu');
Route::get('/delete/menu',                  [MenuController::class, 'deleteMenu'])->name('delete.menu');


Route::post('/add-submenu',                 [MenuController::class, 'addSubmenu'])->name('add.submenu');
Route::post('/add-childsubmenu',            [MenuController::class, 'addChildSubmenu'])->name('add.ChildSubmenu');

// Route::get('/dashboard',                    [DashboardController::class, 'showDashboard'])->name('showDashboard')->middleware(AuthMiddleware::class);

// Route::group(['middleware' => [AuthMiddleware::class, CheckSidebarAccess::class]], function () {
//     Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('showDashboard');    
// });

// getData
    Route::get('/provinces',                [AuthController::class, 'getProvinces'])->name('getProvinces');
    Route::get('/regencies',                [AuthController::class, 'getRegencies'])->name('getRegencies');
    Route::get('/districts',                [AuthController::class, 'getDistricts'])->name('getDistricts');
    Route::get('/villages',                 [AuthController::class, 'getVillages'])->name('getVillages');
//! getData