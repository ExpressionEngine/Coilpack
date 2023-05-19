<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::any(
    config('coilpack.admin_url', 'admin.php'),
    \Expressionengine\Coilpack\Controllers\AdminController::class
)->name('coilpack.admin');

// Recreate Route::fallback() but support ANY method not just GET
$placeholder = 'fallbackPlaceholder';
Route::any(
    "{{$placeholder}}",
    [\Expressionengine\Coilpack\Controllers\FallbackController::class, 'index']
)->where($placeholder, '.*')->name('coilpack.fallback')->fallback();
// Route::fallback([Expressionengine\Coilpack\Controllers\FallbackController::class, 'index']);
