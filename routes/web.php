<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-clients', function () {
    $clients = App\Models\Client::all();
    return $clients;
});
// routes publiques (sans auth)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// routes protégées (avec auth)
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [dashboardController::class, 'index']);
    Route::get('/clients', [ClientController::class, 'index']);
        Route::post('/clients', [ClientController::class, 'store']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit']); 
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']); 
    
});
