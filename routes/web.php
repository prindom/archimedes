<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScormController;
use App\Livewire\ScormUpload;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('scorm/upload', ScormUpload::class)->name('scorm.upload');
    Route::post('scorm/upload', ScormUpload::class)->name('scorm.upload.post');
    Route::get('scorm/content/{id}', [ScormController::class, 'showContent'])->name('scorm.content');
});

require __DIR__.'/auth.php';
