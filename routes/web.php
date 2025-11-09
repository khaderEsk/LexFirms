<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CauseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


Route::get('/', function () {
    return view('login');
});


// Route::resource('ca,dk;uses', CauseController::class);
// Route::g('cases',)->name('cases');

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::get('/causes-day', function () {
    return view('cases.causeDay');
})->name('causeDay');



Route::get('/causes', [CauseController::class, 'index'])->name('causes');


Route::get('/causes-id', function () {
    return view('cases.caseById');
})->name('causeId');


// Route::get('/causes', function () {
//     return view('cases.index');
// })->name('causeAll');

// require __DIR__.'/auth.php';
