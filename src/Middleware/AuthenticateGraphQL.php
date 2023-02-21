<?php

namespace Expressionengine\Coilpack\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthenticateGraphQL
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        $this->authenticate($request);

        return $next($request);
    }

    protected function authenticate($request)
    {
        if (config('coilpack.graphql.auth.enabled') === false) {
            return;
        }

        if (config('coilpack.graphql.auth.driver') === 'token') {
            $this->authenticateToken($request);
        } else {
            // no support this driver
            throw new AuthenticationException('Unable to authenticate.');
        }
    }

    protected function authenticateToken($request)
    {
        if ($request->bearerToken() !== config('coilpack.graphql.auth.token')) {
            throw new AuthenticationException('Unauthenticated.');
        }
    }
}
