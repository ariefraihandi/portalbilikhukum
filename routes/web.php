<?php

//Controllers
    use Illuminate\Support\Facades\Route;
    use App\Http\Middleware\AuthMiddleware;
    use App\Http\Middleware\SidebarMiddleware;
    use App\Http\Middleware\RedirectIfAuthenticated;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\MenuController;
    use App\Http\Controllers\AccountController;
    use App\Http\Controllers\ReferralController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\LawyerController;
    use App\Http\Controllers\Pengacara\PengacaraController;
//!Controllers

Route::get('/', function () {
    return redirect('https://bilikhukum.com');
});

Route::get('/login',                    [AuthController::class, 'showLoginForm'])->name('login')->middleware(RedirectIfAuthenticated::class);
Route::post('/login',                        [AuthController::class, 'login'])->name('submitLogin');
Route::get('/logout',                        [AuthController::class, 'logout'])->name('logout');

Route::middleware([AuthMiddleware::class, SidebarMiddleware::class])->group(function () {
    Route::get('/dashboard',                [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/role/access',              [RoleController::class, 'showRoleAccess'])->name('role.access');
    Route::get('/lawyer',                   [LawyerController::class, 'showLawyer'])->name('lawyer');
    Route::get('/lawyer/detil',             [LawyerController::class, 'showLawyerDetil'])->name('lawyer.detil');
    Route::get('/menu',                     [MenuController::class, 'showMenu'])->name('menu');
    Route::get('/role',                     [RoleController::class, 'showRole'])->name('role');
    Route::get('/menu/submenu',             [MenuController::class, 'showsubMenu'])->name('menu.submenu');
    Route::get('/menu/childmenu',           [MenuController::class, 'showchildMenu'])->name('menu.childmenu');
    
    Route::get('/account/profile',          [AccountController::class, 'showAccount'])->name('account.profile');
    Route::get('/account/detil',            [AccountController::class, 'showAccountDetil'])->name('account.detil');
    Route::get('/refferal',                 [ReferralController::class, 'showReferral'])->name('refferal');

});


Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/register/pengacara',       [AuthController::class, 'showRegisterPengacara'])->name('showRegisterPengacara');
    
    Route::post('/role',                    [RoleController::class, 'rolesStore'])->name('roles.store');
    Route::post('/role/change/access',      [RoleController::class, 'changeAccess'])->name('change.access');

    Route::post('/refferal/generate',       [ReferralController::class, 'refferalGenerate'])->name('refferal.generate');

    Route::post('/office/update',           [LawyerController::class, 'officeUpdate'])->name('office.update');    
    Route::post('/office/update/logo',      [LawyerController::class, 'uploadOfficeLogo'])->name('upload.logo');    
    Route::post('/office/update/cover',     [LawyerController::class, 'uploadOfficeCover'])->name('upload.cover');    
    Route::post('/account/update',          [AccountController::class, 'accountUpdate'])->name('account.update');    
    Route::post('/account/avatar',          [AccountController::class, 'uploadAvatar'])->name('upload.avatar');
    
    //Menu
        //Add
            Route::post('/menu',                        [MenuController::class, 'addMenu'])->name('add.menu');
            Route::post('/add-submenu',                 [MenuController::class, 'addSubmenu'])->name('add.submenu');
            Route::post('/add-childsubmenu',            [MenuController::class, 'addChildSubmenu'])->name('add.ChildSubmenu');
        //!Add

        //Delete
            Route::get('/delete/menu',                  [MenuController::class, 'deleteMenu'])->name('delete.menu');
            Route::get('/delete/submenu',               [MenuController::class, 'deleteSubmenu'])->name('delete.submenu');
            Route::get('/delete/childsubmenu',          [MenuController::class, 'deleteChildSubmenu'])->name('deleteChildSubmenu');
        //!Delete

        //Move
            Route::post('/move-menu',                   [MenuController::class, 'moveMenu'])->name('move.menu');
            Route::post('/move-submenu',                [MenuController::class, 'moveSubmenu'])->name('move.submenu');
            Route::post('/move-childsubmenu',           [MenuController::class, 'moveChildSubmenu'])->name('moveChildSubmenu');
        //!Move
    //Menu

     //Get Data
        Route::get('/getdata/menu',             [MenuController::class, 'getDataMenu'])->name('getDataMenu');
        Route::get('/getdata/submenu',          [MenuController::class, 'getDatasubMenu'])->name('getDatasubMenu');
        Route::get('/getdata/childmenu',        [MenuController::class, 'getDataChildMenu'])->name('getDataChildMenu');
        Route::get('/getdata/user',             [UserController::class, 'getDataUser'])->name('getDataUser');
    //Get Data
});

Route::get('/register',                     [AuthController::class, 'showRegister'])->name('showRegister');
Route::get('/register/member',              [AuthController::class, 'showRegisterMember'])->name('showRegisterMember');

Route::get('/register/mediator',            [AuthController::class, 'showRegisterPengacara'])->name('showRegisterMediator');
Route::get('/verify-email',                 [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('submit-form-daftar',           [AuthController::class, 'submitFormDaftar'])->name('submitFormDaftar');
Route::post('/register/member',             [AuthController::class, 'registerMember'])->name('registerMember');

Route::get('/join',                         [AuthController::class, 'showRegisterJoin'])->name('join');
Route::post('/join',                        [AuthController::class, 'registerJoin'])->name('join.post');

Route::get('/search',                       [PengacaraController::class, 'search'])->name('search');
Route::get('/pengacara',                    [PengacaraController::class, 'showIndex'])->name('showIndex');




// getData
    Route::get('/provinces',                [AuthController::class, 'getProvinces'])->name('getProvinces');
    Route::get('/regencies',                [AuthController::class, 'getRegencies'])->name('getRegencies');
    Route::get('/districts',                [AuthController::class, 'getDistricts'])->name('getDistricts');
    Route::get('/villages',                 [AuthController::class, 'getVillages'])->name('getVillages');
//! getData