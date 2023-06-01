<?php

namespace Expressionengine\Coilpack\Middleware;

use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        $prefix = app('ee')->config->item('cookie_prefix') ?: 'exp_';

        foreach ($request->cookies->keys() as $key) {
            if (strpos($key, $prefix) === 0) {
                $this->disableFor($key);
            }
        }

        return parent::handle($request, $next);
    }
}
