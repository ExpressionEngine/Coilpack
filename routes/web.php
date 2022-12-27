<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::any(config('coilpack.admin_url', 'admin.php'), function () {
    return (new \Expressionengine\Coilpack\Bootstrap\LoadExpressionEngine)
        ->admin()
        ->bootstrap(app())
        ->runGlobal();
});

// Recreate Route::fallback() but support ANY method not just GET
$placeholder = 'fallbackPlaceholder';
Route::any("{{$placeholder}}", [Expressionengine\Coilpack\Controllers\FallbackController::class, 'index'])->where($placeholder, '.*')->fallback();
// Route::fallback([Expressionengine\Coilpack\Controllers\FallbackController::class, 'index']);