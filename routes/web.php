<?php

use App\Http\Controllers\BenchController;
use App\Http\Controllers\Bankjeslocation;
use App\Models\Bench;
use App\Models\Photo;
use App\Models\User;
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

Route::get('/addphoto/{id}', function($id) {
    $bench = Bench::find($id);
    return view('bench.addphoto')->with('bench', $bench)
        ->with('address', BenchController::getReverseLocationAddress($bench->latitude, $bench->longitude));
})->name('bench.addphoto');

Route::post('/report/{id}', [BenchController::class, 'report'])
    ->name('bench.postreport');

Route::post('/add_bench', [BenchController::class, 'add_bench'])
    ->name('bench.add');

Route::post('/post_photo', [BenchController::class, 'add_photo'])
    ->name('bench.post');

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

// Moderator Routes
Route::group(['middleware' => 'role:moderator'], function() {
    Route::get('/moderator_new_items', function() { return view('moderator.new-items'); })->name('moderator_new_items');
    Route::get('/moderator_reported_items', function() { return view('moderator.reported-items'); })->name('moderator_reported_items');

    // Approve new bench
    Route::get('/moderator_new_items/bench/{id}/{approve}', function($id, $approve) {
        $bench = Bench::find($id);
        return $bench->approveNew($id, $approve);
    })->name('bench.approve');

    // Approve new photo
    Route::get('/moderator_new_items/photo/{id}/{approve}', function($id, $approve) {
        $photo = Photo::find($id);
        return $photo->approveNew($id, $approve);
    })->name('photo.approve');

    // Reset reported bench
    Route::get('/moderator_reported_items/bench/{id}/{report_id}/{reset}', function($id, $report_id, $reset) {
        $bench = Bench::find($id);
        return $bench->reset($id, $report_id, $reset);
    })->name('bench.reset');
});

// Admin Routes
Route::group(['middleware' => 'role:admin'], function() {
    Route::get('/admin_dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('admin_dashboard');
    Route::get('/admin_users', function() { return view('admin.users'); })->name('admin_users');
    Route::get('/admin_users_edit/{id}', function($id) { return view('admin.users_edit')->with('user', User::find($id)); })->name('admin_users_edit');
    Route::get('/admin_users_delete/{id}', function($id) { return view('admin.users_delete')->with('user', User::find($id)); })->name('admin_users_delete');
    Route::delete('/admin_users_destroy/{id}', 'App\Http\Controllers\Auth\RegisteredUserController@destroy')->name('admin_users_destroy');
});

//bankjes toevoegen
Route::view('/bankjestoevoegen', 'bankjestoevoegen')->middleware('role:any')->name('bankjestoevoegen');

// Bench Controller
Route::get('/get-benches-area/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@benchesInArea');
Route::get('/get-benches-global/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@benchesGlobal');
Route::get('/get-reverse-address/{latitude}/{longitude}', 'App\Http\Controllers\BenchController@getReverseLocation');

require __DIR__.'/auth.php';
