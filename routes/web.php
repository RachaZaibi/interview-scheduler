<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Public Routes – Candidates
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/interviews');
});

Route::get('/interviews', [InterviewController::class, 'index'])
    ->name('interviews.index');

Route::get('/interviews/book/{slot}', [InterviewController::class, 'create'])
    ->name('interviews.create');

Route::post('/interviews/book', [InterviewController::class, 'store'])
    ->name('interviews.store');

// Authentication routes (login)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Admin Routes – Interview Slots
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {

    Route::get('/slots', [SlotController::class, 'index'])
        ->name('admin.slots.index');

    Route::get('/slots/create', [SlotController::class, 'create'])
        ->name('admin.slots.create');

    Route::post('/slots', [SlotController::class, 'store'])
        ->name('admin.slots.store');

    // Appointments (bookings)
    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->name('admin.appointments.index');

    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])
        ->name('admin.appointments.show');

    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->name('admin.appointments.destroy');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

});
