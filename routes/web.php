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
    use App\Http\Controllers\BisnisController;
    use App\Http\Controllers\ReferralController;
    use App\Http\Controllers\JdihController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\KlienChatController;
    use App\Http\Controllers\LawyerController;
    use App\Http\Controllers\WarisController;
    use App\Http\Controllers\Pengacara\PengacaraController;
    use App\Http\Controllers\Index\IndexController;
//!Controllers

Route::get('/',                             [IndexController::class, 'index'])->name('index.index');
Route::post('/mailing',                     [IndexController::class, 'storeMailing'])->name('store.mailing');

Route::get('/login',                        [AuthController::class, 'showLoginForm'])->name('login')->middleware(RedirectIfAuthenticated::class);
Route::get('/verifymail',                   [AuthController::class, 'showVerifyMail'])->name('verifyMail')->middleware(RedirectIfAuthenticated::class);

Route::post('/login',                       [AuthController::class, 'login'])->name('submitLogin');
Route::get('/logout',                       [AuthController::class, 'logout'])->name('logout');

Route::middleware([AuthMiddleware::class, SidebarMiddleware::class])->group(function () {
    Route::get('/dashboard',                [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/lawyer',                   [LawyerController::class, 'showLawyer'])->name('lawyer');
    Route::get('/lawyer/detil',             [LawyerController::class, 'showLawyerDetil'])->name('lawyer.detil');
    Route::get('/lawyer/perkara',           [LawyerController::class, 'showLawyerPerkara'])->name('lawyer.perkara');
    Route::get('/lawyer/klien',             [LawyerController::class, 'showKlienLawyer'])->name('lawyer.klien');
    Route::get('/lawyer/website',           [LawyerController::class, 'showWebsiteLawyer'])->name('lawyer.website');
    Route::get('/lawyer/member',            [LawyerController::class, 'showMemberDetil'])->name('lawyer.member');
    
    Route::get('/menu',                     [MenuController::class, 'showMenu'])->name('menu');
    Route::get('/role',                     [RoleController::class, 'showRole'])->name('role');
    Route::get('/menu/submenu',             [MenuController::class, 'showsubMenu'])->name('menu.submenu');
    Route::get('/menu/childmenu',           [MenuController::class, 'showchildMenu'])->name('menu.childmenu');
    
    Route::get('/account/profile',          [AccountController::class, 'showAccount'])->name('account.profile');
    Route::get('/account/detil',            [AccountController::class, 'showAccountDetil'])->name('account.detil');
    Route::get('/account/security',         [AccountController::class, 'showSecurity'])->name('account.security');
    Route::get('/refferal',                 [ReferralController::class, 'showReferral'])->name('refferal');
    
    Route::get('/jdih/uu/list',             [JdihController::class, 'showUUList'])->name('jdih.uu.list');
    

    Route::get('/bisnis/office/list',       [BisnisController::class, 'showOfficeList'])->name('bisnis.office.list');
    Route::get('/bisnis/office/verify',     [BisnisController::class, 'showOfficeVerify'])->name('bisnis.office.verify');
    Route::get('/bisnis/user/list',         [BisnisController::class, 'showUserList'])->name('bisnis.user.list');
});


Route::middleware([AuthMiddleware::class])->group(function () {

    Route::post('/change-password',          [AuthController::class, 'changePassword'])->name('change.password');

    Route::post('/jdih/uu/store',           [JdihController::class, 'storeRule'])->name('store.rule');
    Route::post('/jdih/uu/bab',             [JdihController::class, 'storeBab'])->name('storeBab');
    Route::post('/jdih/uu/bagian',          [JdihController::class, 'storebagian'])->name('store.bagian');
    Route::get('/ruleData',                 [JdihController::class, 'getRuleData'])->name('getRuleData');
    Route::get('/babs/{rule_b_undang_id}',  [JdihController::class, 'getBabs']);
    Route::get('/bagian/{babId}',           [JdihController::class, 'getBagiansByBabId']);
    
    Route::post('jdih/uu/pasal',            [JdihController::class, 'storePasal'])->name('store.pasal');

    
    Route::get('/bisnis/verify',            [BisnisController::class, 'officeVerify'])->name('bisnis.verify');
    Route::post('/bisnis/updateDoc',        [BisnisController::class, 'officeUpdateDoc'])->name('bisnis.updateDoc');    
    Route::get('/delete-office/{id}',       [BisnisController::class, 'destroy'])->name('delete-office');    
    Route::get('/bisnis/officestatus',      [BisnisController::class, 'changeStatus'])->name('office.changeStatus');


    Route::get('/register/pengacara',       [AuthController::class, 'showRegisterPengacara'])->name('showRegisterPengacara');
    
    Route::post('/role',                    [RoleController::class, 'rolesStore'])->name('roles.store');
    Route::post('/role/change/access',      [RoleController::class, 'changeAccess'])->name('change.access');
    Route::post('/roles/Destrtoy',          [RoleController::class, 'rolesDestroy'])->name('roles.destroy');
    

    Route::post('/refferal/generate',       [ReferralController::class, 'refferalGenerate'])->name('refferal.generate');

    Route::post('/office/update',           [LawyerController::class, 'officeUpdate'])->name('office.update');    
    Route::post('/office/update/website',   [LawyerController::class, 'updateWebsite'])->name('office.updateWebsite');    
    Route::post('/office/documents',        [LawyerController::class, 'officeDocuments'])->name('office.documents');    
    Route::post('/office/update/logo',      [LawyerController::class, 'uploadOfficeLogo'])->name('upload.logo');    
    Route::post('/office/update/cover',     [LawyerController::class, 'uploadOfficeCover'])->name('upload.cover'); 
    Route::post('/office/update/image',     [LawyerController::class, 'uploadImageWebsite'])->name('upload.imageWebsite'); 
    Route::post('/office/update/perkara',   [LawyerController::class, 'officeUpperkara'])->name('office.upperkara'); 
    Route::get('/office/askverified',       [LawyerController::class, 'officeAskverified'])->name('office.askverified'); 
    Route::delete('/office/documents/{id}', [LawyerController::class, 'destroy'])->name('office.documents.delete');      
    Route::get('/getcase',                  [LawyerController::class, 'getCase'])->name('getcase');
    Route::put('/update/office-case/{id}',  [LawyerController::class, 'updateOfficeCase'])->name('updateOfficeCase');
    Route::get('/delete/officecase',        [LawyerController::class, 'deleteOfficeCase'])->name('deleteOfficeCase');
    Route::post('/store/gallery',           [LawyerController::class, 'storeGallery'])->name('storeGallery');
    Route::get('/join/office',              [LawyerController::class, 'showJoinOffice'])->name('storeGallery');
    Route::post('/join/office',             [LawyerController::class, 'submitJoinOffice'])->name('submitJoinOffice');
    Route::get('/delete/member',            [LawyerController::class, 'deleteMember'])->name('delete.member');
    

    Route::post('/account/update',          [AccountController::class, 'accountUpdate'])->name('account.update');    
    Route::post('/account/avatar',          [AccountController::class, 'uploadAvatar'])->name('upload.avatar');
    
    Route::get('/hubungi',                  [KlienChatController::class, 'hubungi'])->name('hubungiKlien');
    Route::post('/update/statusklien',      [KlienChatController::class, 'updateStatusKlien'])->name('updateStatusKlien');
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
        Route::get('/getdata/menu',                 [MenuController::class, 'getDataMenu'])->name('getDataMenu');
        Route::get('/getdata/submenu',              [MenuController::class, 'getDatasubMenu'])->name('getDatasubMenu');
        Route::get('/getdata/childmenu',            [MenuController::class, 'getDataChildMenu'])->name('getDataChildMenu');
        Route::get('/getdata/user',                 [UserController::class, 'getDataUser'])->name('getDataUser');
        Route::get('/getdata/allMember',            [BisnisController::class, 'getAllMember'])->name('getAllMember');
        Route::get('/getdata/alloffice',            [BisnisController::class, 'getAllOffice'])->name('getAllOffice');
        Route::get('/getdata/refferal',             [AccountController::class, 'getDataRefferal'])->name('getDataRefferal');
        Route::get('/getdata/perkara/{office_id}',  [LawyerController::class, 'getPerkaraData'])->name('getPerkaraData');
        Route::get('/getWebsite',                   [LawyerController::class, 'checkWebsite'])->name('checkWebsite');
        Route::post('/addWebsite',                  [LawyerController::class, 'addWebsite'])->name('addWebsite');
        Route::get('/getdata/klien',                [KlienChatController::class, 'getDataKlien'])->name('getDataKlien');
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
Route::post('/email',                       [AuthController::class, 'registerJoin'])->name('join.post');
Route::post('/verifymail',                  [AuthController::class, 'sendEmailVerify'])->name('send.emailverify');

Route::get('/search',                       [PengacaraController::class, 'search'])->name('search');
Route::get('/location/{code}',              [PengacaraController::class, 'getNameByCode'])->name('getNameByCode');
Route::get('/search-offices',               [PengacaraController::class, 'searchOffices'])->name('search-offices');
Route::get('/pengacara',                    [PengacaraController::class, 'showIndex'])->name('showPengacara');
Route::get('/pengacara/{website}',          [PengacaraController::class, 'showLandingPage'])->name('showLandingPage');

Route::get('/kamus',                        [JdihController::class, 'showLaw'])->name('showDictionary');
Route::get('/kamus/{type?}/{number?}/{year?}/{pasal?}/{ayat?}/{huruf?}/{angka?}', [JdihController::class, 'showLaw'])->name('showLaw');

Route::post('/klienchat/store',             [KlienChatController::class, 'klienChat'])->name('klienchat.store');

//App Hitung Waris
Route::get('/hitung-waris',                     [WarisController::class, 'index'])->name('hitungWaris');
//!App Hitung Waris


// getData
    Route::get('/provinces',                [AuthController::class, 'getProvinces'])->name('getProvinces');
    Route::get('/regencies',                [AuthController::class, 'getRegencies'])->name('getRegencies');
    Route::get('/districts',                [AuthController::class, 'getDistricts'])->name('getDistricts');
    Route::get('/villages',                 [AuthController::class, 'getVillages'])->name('getVillages');
    Route::get('/search/law',               [JdihController::class, 'search'])->name('search.law');
//! getData