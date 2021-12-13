<?php

use Illuminate\Support\Facades\Auth;
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
})->name('welcome');

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

Route::get('/admin_dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->middleware('role:admin')->name('admin_dashboard');
Route::get('/moderator_dashboard', 'App\Http\Controllers\Moderator\DashboardController@index')->middleware('role:moderator')->name('moderator_dashboard');
Route::get('/user_dashboard', 'App\Http\Controllers\User\DashboardController@index')->middleware('role:user')->name('user_dashboard');

// Bench Controller
Route::get('/get-benches-area/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@benchesInArea');

require __DIR__.'/auth.php';
