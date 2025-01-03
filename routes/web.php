<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Language\LanguageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\Pages\LandingController;
use App\Http\Controllers\Pages\DashboardController;
use App\Http\Controllers\Pages\TasksController;
use App\Http\Controllers\Pages\UsersController;
use App\Http\Controllers\Pages\DeclarantController;
use App\Http\Controllers\Pages\SettingController;
use App\Http\Controllers\Pages\PropertyController;
use App\Http\Controllers\Pages\PoliceStationController;


use App\Http\Controllers\Pages\GuestTasksController;

// Route::get('/', [LandingController::class, 'index'])->name('landing');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

Route::get('terms-and-conditions', [DashboardController::class, 'terms_of_service'])->name('terms_of_service');
Route::get('privacy-policy', [DashboardController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('faq', [DashboardController::class, 'faq'])->name('faq');
Route::get('contact-us', [DashboardController::class, 'contact_us'])->name('contact_us');

// Route::withoutMiddleware([AuthMiddleware::class])->group(function () {
//   Route::get('/', [HomePage::class, 'index'])->name('pages-home');
// });

Route::get('guest_task/{token}', [GuestTasksController::class, 'index'])->name('guest.task');
Route::post('guest_task/submit', [GuestTasksController::class, 'submit'])->name('guest.submit');

Route::group(['middleware' => 'guest'], function () {
  Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
  Route::post('register', [RegisteredUserController::class, 'store']);
  Route::get('verify-email', [RegisteredUserController::class, 'verify_email'])->name('verify.email');
  Route::post('verify-resent', [RegisteredUserController::class, 'resentEmail'])->name('verify.resent');

  Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
  Route::post('login', [AuthenticatedSessionController::class, 'login_act']);

  Route::get('oauth/{driver}', [AuthenticatedSessionController::class, 'redirectToProvider'], )->name('social.oauth');
  Route::get('oauth/{driver}/callback', [AuthenticatedSessionController::class, 'handleProviderCallback'])->name('social.callback');

  Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
  Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

  Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

  Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');


  Route::get('verify/{token}', [RegisteredUserController::class, 'verifyAccount'])->name('verify');

});

Route::group(['middleware' => 'auth'], function () {
  // Route::post('logout', [RegisteredUserController::class, 'destroy'])->name('logout');
  Route::get('logout', [RegisteredUserController::class, 'destroy'])->name('log-out');
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/', [DashboardController::class, 'index'])->name('index');

  Route::get('tasks', [TasksController::class, 'index'])->name('tasks');

  Route::get('tasks/list', [TasksController::class, 'list'])->name('tasks.list');
  Route::get('task', [TasksController::class, 'create'])->name('tasks.create');
  Route::post('task', [TasksController::class, 'store'])->name('tasks.store');
  Route::get('task/{id}', [TasksController::class, 'show'])->name('tasks.show');
  Route::get('task/{id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
  Route::post('task/{id}/edit', [TasksController::class, 'update'])->name('tasks.update');
  Route::delete('task/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');
  Route::post('send/{id}', [TasksController::class, 'send'])->name('tasks.send');
  Route::post('delete/{id}', [TasksController::class, 'delete'])->name('tasks.delete');
  Route::post('generate/{id}', [TasksController::class, 'generatePDF'])->name('tasks.generate');
  Route::post('send-pec/{id}', [TasksController::class, 'sendPec'])->name('tasks.send-pec');
  Route::post('cancel/{id}', [TasksController::class, 'cancel'])->name('tasks.cancel');

  Route::get('pdf/{id}', [TasksController::class, 'displayPDF'])->name('tasks.display');

  Route::get('users', [UsersController::class, 'index'])->name('users');
  Route::get('users/getlist', [UsersController::class, 'getlist'])->name('users.getlist');
  Route::get('users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
  Route::delete('users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
  Route::post('users/store', [UsersController::class, 'store'])->name('users.store');

  Route::get('declarants', [DeclarantController::class, 'index'])->name('declarants');
  Route::get('declarants/getlist', [DeclarantController::class, 'getlist'])->name('declarants.getlist');
  Route::get('declarants/{id}/edit', [DeclarantController::class, 'edit'])->name('declarants.edit');
  Route::delete('declarants/{id}', [DeclarantController::class, 'destroy'])->name('declarants.destroy');
  Route::post('declarants/store', [DeclarantController::class, 'store'])->name('declarants.store');

  Route::get('properties', [PropertyController::class, 'index'])->name('properties');
  Route::get('properties/getlist', [PropertyController::class, 'getlist'])->name('property.getlist');
  Route::get('properties/{id}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
  Route::delete('properties/{id}', [PropertyController::class, 'destroy'])->name('properties.destroy');
  Route::post('properties/store', [PropertyController::class, 'store'])->name('properties.store');

  Route::get('police_stations', [PoliceStationController::class, 'index'])->name('police_stations');
  Route::get('police_stations/getlist', [PoliceStationController::class, 'getlist'])->name('police_stations.getlist');
  Route::get('police_stations/{id}/edit', [PoliceStationController::class, 'edit'])->name('police_stations.edit');
  Route::delete('police_stations/{id}', [PoliceStationController::class, 'destroy'])->name('police_stations.destroy');
  Route::post('police_stations/store', [PoliceStationController::class, 'store'])->name('police_stations.store');

  Route::get('setting/account', [SettingController::class, 'index'])->name('setting.account');
  Route::post('setting/account', [SettingController::class, 'update'])->name('setting.update');
  Route::get('setting/security', [SettingController::class, 'security'])->name('setting.security');
  Route::post('setting/update_password', [SettingController::class, 'updatePassword'])->name('setting.update_password');
  Route::post('setting/send-otp', [SettingController::class, 'sendOTP'])->name('setting.send-otp');
  Route::post('setting/verify-otp', [SettingController::class, 'verifyOTP'])->name('setting.verify-otp');

});



// --------------------------- FOR TEST ----------------------------- //
Route::get('/run-artisan', function () {
  $exitCode = Artisan::call(request()->get('command'));
  $output = Artisan::output();

  return response()->json([
      'exitCode' => $exitCode,
      'output' => $output
  ]);
});
