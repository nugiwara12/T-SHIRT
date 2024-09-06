<?php

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserManagementController;

use App\Http\Controllers\ContactUsFormController;
use App\Http\Livewire\Users;

use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationMailer;


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
// ----------------------------- Start Backlog-----------------------//
// Route::group(['middleware' => 'prevent-back-history'],function(){


Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



 

// ----------------------------- LOGIN AND RESITER -----------------------//
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

// ----------------------------- DASHBOARD -----------------------//
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

// ----------------------------- PRODUCT -----------------------//
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
    });
 
    // Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
});

// ----------------------------- User management -----------------------//
Route::controller(UserManagementController::class)->prefix('usermanagement')->group(function () {
    Route::get('', 'index')->name('usermanagement');
    Route::get('create', 'create')->name('usermanagement.create');
    Route::post('store', 'store')->name('usermanagement.store');
    Route::get('show/{id}', 'show')->name('usermanagement.show');
    Route::get('edit/{id}', 'edit')->name('usermanagement.edit');
    Route::put('edit/{id}', 'update')->name('usermanagement.update');
    Route::delete('destroy/{id}', 'destroy')->name('usermanagement.destroy');
});

Route::get('/get-notification-count', [NotificationController::class, 'getNotificationCount']);
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// ----------------------------- ACTIVITY-LOGS -----------------------//
Route::get('activity/log', [UserManagementController::class, 'activity'])->name('activity/log');

// ----------------------------- OTP -----------------------//
Route::post('reset_password', [AuthController::class,'resetPassword']);
Route::get('forgot-password', function () {
    if(Session::has('current_user')){
        return redirect('dashboard');
    }else{
        return view('forgot-password');
    }
})->middleware('guest')->name('password.request');

Route::get('re-new-password', function (){

    return view('new-password')->with('failed','Invalid OTP code');
});
Route::post('/new-password', [AuthController::class,'findUserToChangePass']);
route::get('test-mail',function(){
    // Inside your function/method
    Session::put('reset_otp_code', random_int(000000,999999));
    Mail::to('sarmientojohnchristoper@gmail.com')->send(new SendVerificationMailer());
});
Route::get('/new-password', [AuthController::class, 'newPassword'])->name('new-password');





// ----------------------------- Contact Us-----------------------//
Route::get('/contact', [ContactUsFormController::class, 'createForm']);
 
Route::post('/contact', [ContactUsFormController::class, 'ContactUsForm'])->name('contact.store');

Route::get('/index', [ContactUsFormController::class, 'index'])->name('contacts.index');
Route::get('/contacts/{id}', [ContactUsFormController::class, 'show'])->name('contact.show');
Route::delete('/contacts/{id}', [ContactUsFormController::class, 'destroy'])->name('contact.destroy');


// ----------------------------- End Of Route Back Log -----------------------//
// });