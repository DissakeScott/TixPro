<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TempsPasseController;
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

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


// routes protégées (avec auth)

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [dashboardController::class, 'index']);
    Route::get('/clients', [ClientController::class, 'index']);
        Route::post('/clients', [ClientController::class, 'store']);

   Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


   
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit']); 
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']); 
    
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);

    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit']); 
    Route::put('/tickets/{id}', [TicketController::class, 'update']); 
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);


    Route::get('/projets', [ProjetController::class, 'index']);
    Route::post('/projets', [ProjetController::class, 'store']);
    Route::get('/projets/{id}/edit', [ProjetController::class, 'edit']); 
    Route::put('/projets/{id}', [ProjetController::class, 'update']); 
    Route::delete('/projets/{id}', [ProjetController::class, 'destroy']);


    Route::post('/tickets/{ticket}/temps', [TempsPasseController::class, 'store']);
});

Route::middleware(['auth', 'role:Client'])->group(function () {
    
   Route::get('/portail-client', [ClientPortalController::class, 'index'])->name('portail.client');
    
    // Valider/Refuser un ticket
    Route::post('/portail-client/tickets/{id}/valider', [ClientPortalController::class, 'validerTicket']);
    
});
