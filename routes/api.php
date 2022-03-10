<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'input'], function(){
    Route::get('/auto', [FormController::class, 'autohandphone']);
    Route::post('/proses', [FormController::class, 'prosesinput']);
});

Route::group(['prefix' => 'output'], function() {
    Route::get('/', [FormController::class, 'tampiloutput']);
    Route::post('/detail', [FormController::class, 'detailoutput']);
    Route::post('/edit', [FormController::class, 'editoutput']);
    Route::post('/delete', [FormController::class, 'deleteoutput']);
});
