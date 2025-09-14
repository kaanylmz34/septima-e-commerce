<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Auth\Services\LoginService;
use App\Auth\Objects\AuthCredentialsObject;

Route::get('/', function () {

    try
    {
        $loginService = new LoginService();
        $c = [
            'phone' => '+905555555555',
        ];
        $authCredentialsObject = new AuthCredentialsObject(method: 'phone', credentials: $c);
        $loginService->loginWithPhone($authCredentialsObject);
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
