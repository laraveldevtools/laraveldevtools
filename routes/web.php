<?php

use Illuminate\Support\Facades\Route;
use Laraveldevtools\Database\Components\DatabaseDevTools;

Route::group(['middleware' => ['web']], function () {
    Route::get('devtools', DatabaseDevTools::class)->name('devtools.database');
});