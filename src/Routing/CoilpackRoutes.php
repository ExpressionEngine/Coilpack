<?php

namespace Expressionengine\Coilpack\Routing;

class CoilpackRoutes
{
    /**
     * Register default Coilpack routes.
     *
     * @param  array  $options
     * @return callable
     */
    public function coilpack()
    {
        return function ($options = []) {
            $namespace = class_exists($this->prependGroupNamespace('Coilpack\FallbackController')) ? null : 'Expressionengine\Coilpack\Controllers';

            $this->group(['namespace' => $namespace], function () use ($options) {
                if ($options['admin'] ?? true) {
                    $this->any(
                        config('coilpack.admin_url', 'admin'), \Expressionengine\Coilpack\Controllers\AdminController::class
                    )->name('coilpack.admin');
                }

                if ($options['fallback'] ?? true) {
                    // Recreate Route::fallback() but support ANY method not just GET
                    $placeholder = 'fallbackPlaceholder';
                    $this->any("{{$placeholder}}", [\Expressionengine\Coilpack\Controllers\FallbackController::class, 'index'])
                        ->where($placeholder, '.*')
                        ->name('coilpack.fallback')
                        ->fallback();
                }
            });
        };
    }
}
