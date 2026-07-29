<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SertifikatController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::get('/sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create', fn () => inertia('sertifikat/Create'))->name('sertifikat.create');
    Route::post('/sertifikat', [SertifikatController::class, 'store'])->name('sertifikat.store');
    Route::get('/sertifikat/{sertifikat}/edit', [SertifikatController::class, 'edit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{sertifikat}', [SertifikatController::class, 'update'])->name('sertifikat.update');
    Route::delete('/sertifikat/{sertifikat}', [SertifikatController::class, 'destroy'])->name('sertifikat.destroy');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/create', fn () => inertia('profil/Create'))->name('profil.create');
    Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store');
    Route::get('/profil/{profil}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/{profil}', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/{profil}', [ProfilController::class, 'destroy'])->name('profil.destroy');
});

require __DIR__.'/settings.php';
