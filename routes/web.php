<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;


Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
// Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
// Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});



// use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PrimaryController;
use App\Http\Controllers\SecondaryController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatusCheckController;
Route::group(['middleware' => 'auth'], function () {

	Route::get('/productHome', [ProductController::class, 'index'])->name('productHome');
	Route::post('/delete-products', [ProductController::class, 'deleteproduct'])->name('deleteproduct');
	Route::get('/products/excelView', [ProductController::class, 'excelView'])->name('products.excelView');
	Route::get('/products/excel', [ProductController::class, 'downloadexcel'])->name('download-excel');
	Route::resource('products',ProductController::class);
	Route::get('/get-product-category',[ProductController::class, 'getProductCategory']);
	Route::get('/get-product-subcategory',[ProductController::class, 'getProductSubcategory']);
	Route::get('/get-product-items',[ProductController::class, 'getProductItems']);
	Route::get('/products/view/{id}', [ProductController::class, 'view'])->name('products.view');

	//Primary Controller
	Route::get('/get-related-data',[PrimaryController::class, 'getRelatedData']);
	Route::get('/primaryHome', [PrimaryController::class, 'index'])->name('primaryHome');
	Route::post('/delete-primaries', [PrimaryController::class, 'deleteprimary'])->name('deleteprimary');
	Route::resource('primaries',PrimaryController::class);
	Route::get('/primaries/view/{id}', [PrimaryController::class, 'view'])->name('primaries.view');

	Route::get('/primaries/printLabel/{id}', [PrimaryController::class, 'printLabel'])->name('primaries.printLabel');
	Route::post('/primaryprint/{id}', [PrimaryController::class, 'primaryprint'])->name('primaryprint');

	//Secondary Controller
	Route::get('/get-srelated-data',[SecondaryController::class, 'getSRelatedData']);
	Route::get('/secondaries/index',[SecondaryController::class, 'index'])->name('secondaries.index');
	Route::get('/secondaries/create',[SecondaryController::class, 'create'])->name('secondaries.create');
	Route::post('secondaries/store',[SecondaryController::class, 'store'])->name('secondaries.store');
	Route::get('/secondaries/view/{id}', [SecondaryController::class, 'view'])->name('secondaries.view');
	Route::get('/secondaries/printLabel/{id}', [SecondaryController::class, 'printLabel'])->name('secondaries.printLabel');
	Route::get('/secondaryPrint/{id}', [SecondaryController::class, 'secondaryPrint'])->name('secondaryPrint');

	//Admin Controllers
	Route::get('/adminHome', [AdminController::class, 'index'])->name('adminhome');
	Route::post('/delete-users', [AdminController::class, 'deleteUsers'])->name('deleteUsers');
	Route::post('/passwordupdate-users/{id}', [AdminController::class, 'passwordupdate'])->name('users.passwordupdate');
	
	//Authenticated Routes
	Route::middleware('auth')->group(function(){
		//User Management
		Route::resource('users',AdminController::class);
		//To update Users
	Route::get('/users/status/{user_id}/{status_code}',[AdminController::class, 'updateStatus'])->name('users.status.update');
	});
	

	Route::post('/users/{user}/roles',[AdminController::class, 'assignRole'])->name('users.roles');
	Route::delete('/users/{user}/roles/{role}',[AdminController::class, 'removeRole'])->name('users.roles.remove');
	Route::post('/users/{user}/permissions',[AdminController::class, 'givePermission'])->name('users.permissions');
	Route::delete('/users/{user}/permissions/{permission}',[AdminController::class, 'revokePermission'])->name('users.permissions.revoke');

	//Route::get('/users/status/{user_id}/{status_code}',[AdminController::class,'updateStatus'])->name('users.status.update');

	// StatusCheckController
	Route::get('/status', [StatusCheckController::class, 'index'])->name('status');
	Route::post('/status/label', [StatusCheckController::class, 'checkLabel'])->name('status.checkLabel');
	Route::post('/status/product', [StatusCheckController::class, 'checkProduct'])->name('status.checkProduct');
});


//Added by MMC cron routes
Route::get('/cron/getApplications', [CronController::class, 'getApplications'])->name('applications');
Route::get('/cron/getUnitOfMeasurements', [CronController::class, 'getUnitOfMeasurements'])->name('getUnitOfMeasurements');
Route::get('/cron/getCategories', [CronController::class, 'getCategories'])->name('getCategories');
Route::get('/cron/getSubCategories', [CronController::class, 'getSubCategories'])->name('getSubCategories');
Route::get('/cron/getItems', [CronController::class, 'getItems'])->name('getItems');
Route::get('/cron/getAPIToken', [CronController::class, 'getAPIToken'])->name('getAPIToken');
Route::get('/cron/apiSyncProducts', [CronController::class, 'apiSyncProducts'])->name('apiSyncProducts');
Route::get('/cron/apiSyncPrimaryLabels', [CronController::class, 'apiSyncPrimaryLabels'])->name('apiSyncPrimaryLabels');
Route::get('/cron/apiSyncSecondaryLabels', [CronController::class, 'apiSyncSecondaryLabels'])->name('apiSyncSecondaryLabels');




