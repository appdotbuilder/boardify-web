<?php

use App\Http\Controllers\BoardifyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SlideshowController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page - Boardify main functionality
Route::get('/', [BoardifyController::class, 'index'])->name('home');
Route::get('/events', function() { 
    return app(\App\Http\Controllers\BoardifyController::class)->show('events'); 
})->name('boardify.events');
Route::get('/templates', function() { 
    return app(\App\Http\Controllers\BoardifyController::class)->show('templates'); 
})->name('boardify.templates');

// Event slideshow (public access for display)
Route::get('/events/{event}/slideshow', [SlideshowController::class, 'show'])->name('events.slideshow');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Event management routes
    Route::resource('events', EventController::class);
    
    // Greeting routes
    Route::resource('greetings', GreetingController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/events/{event}/greetings/create', [GreetingController::class, 'create'])->name('event.greetings.create');
    
    // Payment routes
    Route::get('/greetings/{greeting}/payment', [PaymentController::class, 'show'])->name('greetings.payment');
    Route::post('/greetings/{greeting}/payment', [PaymentController::class, 'store'])->name('greetings.payment.process');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
