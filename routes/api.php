<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\BookController::class)
    ->prefix('books')
    ->group(function () {
        Route::post('', 'store');
        Route::get('', 'index');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
