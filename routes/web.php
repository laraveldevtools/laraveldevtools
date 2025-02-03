<?php

use Illuminate\Support\Facades\Route;
use Laraveldevtools\Laraveldevtools\Components\Main;

Route::group(['middleware' => ['web']], function () {
    Route::get('devtools', Main::class)->name('laraveldevtools');
});