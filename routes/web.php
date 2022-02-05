<?php

use App\Http\Controllers\DocumentationController;
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

Route::view('/', 'index');
Route::get('{locale}/{doc}/{version}/{page}', DocumentationController::class)
    ->name('docs.show')
    ->where('locale', '[\w]+([\-_]\w+){0,2}')
    ->where('doc', 'laravel') // @TODO: support more docs
    ->where('page', '[\w\-_/]+');
