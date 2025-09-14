<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Auth\Services\LoginService;
use App\Auth\Objects\AuthCredentialsObject;

Route::get('/', function () {

    

})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
