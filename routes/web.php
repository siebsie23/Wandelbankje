<?php

use App\Http\Controllers\BenchController;
use App\Http\Controllers\Bankjeslocation;
use App\Models\Bench;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stevebauman\Location\Facades\Location;

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

// Pages accessible by unregistered users.
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/global', function () {
    return view('globalbenches');
})->name('global');

Route::get('/details/{id}', function($id) {
    $bench = Bench::find($id);
    return view('bench.details')->with('bench', $bench)
        ->with('address', BenchController::getReverseLocationAddress($bench->latitude, $bench->longitude));
})->name('bench.details');

Route::get('/details/{id}/{like}', function($id, $like) {
    $bench = Bench::find($id);
    return $bench->addLike($id, $like);
})->name('bench.like');

Route::get('/report/{id}', function($id) {
    $bench = Bench::find($id);
    return view('bench.report')->with('bench', $bench)
        ->with('address', BenchController::getReverseLocationAddress($bench->latitude, $bench->longitude));
})->name('bench.report');

Route::post('/report/{id}', [BenchController::class, 'report'])
    ->name('bench.postreport');

// Only accessible by registered users.
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    switch($role) {
        case 'admin':
            return redirect(route('admin_dashboard'));
        case 'moderator':
            return redirect(route('moderator_dashboard'));
        case 'user':
            return redirect(route('user_dashboard'));
        default:
            return '/';
    }
})->middleware(['auth'])->name('dashboard');

Route::get('/moderator_dashboard', 'App\Http\Controllers\Moderator\DashboardController@index')->middleware('role:moderator')->name('moderator_dashboard');
Route::get('/user_dashboard', 'App\Http\Controllers\User\DashboardController@index')->middleware('role:user')->name('user_dashboard');

// Admin Routes
Route::get('/admin_dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->middleware('role:admin')->name('admin_dashboard');
Route::get('/admin_users', function() {
   return view('admin.users');
})->middleware('role:admin')->name('admin_users');
Route::get('/admin_users_create', function() { })->middleware('role:admin')->name('admin_users_create');
Route::get('/admin_users_edit/{id}', function() { })->middleware('role:admin')->name('admin_users_edit');
Route::get('/admin_users_delete/{id}', function() { })->middleware('role:admin')->name('admin_users_delete');

//bankjes toevoegen
Route::view('/bankjestoevoegen', 'bankjestoevoegen');

// Bench Controller
Route::get('/get-benches-area/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@benchesInArea');
Route::get('/get-benches-global/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@benchesGlobal');
Route::get('/get-reverse-address/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@getReverseLocation');

require __DIR__.'/auth.php';
