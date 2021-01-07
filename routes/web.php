<?php

use App\Http\Controllers\TeacherController;
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/create/teacher', [TeacherController::class, 'create']);
    Route::get('/view/teacher/{slug}', [TeacherController::class, 'show']);
    Route::post('/store/teacher', [TeacherController::class, 'store']);
});

require __DIR__.'/auth.php';
