<?php


use App\Http\Controllers\API\AuthController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;


// MAIN
//Route::post('/auth/logout', [AuthController::class, 'destroy'])->name('filament.admin.auth.logout');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');


    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';

