<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Auth\Services\LoginService;
use App\Auth\Objects\AuthCredentialsObject;

Route::get('/', function () {

    try
    {
        $loginService = new LoginService();
        $authCredentialsObject = new AuthCredentialsObject(phone: '05321235456');
        $loginService->login($authCredentialsObject);
    }
    catch (\Exception $e)
    {
        echo $e->getMessage();
    }

})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
