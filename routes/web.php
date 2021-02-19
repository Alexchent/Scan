<?php

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

Route::get('/scan', [\App\Http\Controllers\ScanController::class,'index']);
Route::get('/files', [\App\Http\Controllers\FilesController::class,'index']);
Route::delete('/files/{file}', [\App\Http\Controllers\FilesController::class,'destroy'])->name('files.destroy');
Route::get('/files/{file_path}', [\App\Http\Controllers\FilesController::class,'show'])->name('files.show');
