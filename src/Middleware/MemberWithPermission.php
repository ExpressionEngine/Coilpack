<?php

namespace Expressionengine\Coilpack\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class MemberWithPermission
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

        if ($request->user()->permissions->whereIn('permission', $permissions)->isEmpty()) {
            throw new \Exception('Member not authorized');
        }

        return $next($request);
    }

    protected function authenticate($request)
    {
        if ($this->auth->guard('coilpack')->check()) {
            return $this->auth->shouldUse('coilpack');
        }

        throw new AuthenticationException(
            'Unauthenticated.',
            ['coilpack'],
            null
        );
    }
}
