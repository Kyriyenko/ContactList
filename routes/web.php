<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;



Route::get('/', function () {
    return view('index');
});

Route::get('/api',  [ContactController::class, 'showData']);
Route::get('/api/delete/{id}',  [ContactController::class, 'deleteContact']);
Route::post('/api/posts/',  [ContactController::class, 'create']);
Route::post('/api/edit/',  [ContactController::class, 'update']);
