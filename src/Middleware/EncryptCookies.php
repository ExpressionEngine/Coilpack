<?php

namespace Expressionengine\Coilpack\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Determine whether encryption has been disabled for the given cookie.
     *
     * @param  string  $name
     * @return bool
     */
    public function isDisabled($name)
    {
        // If this is not Laravel's session cookie and it matches ExpressionEngine's
        // cookie prefix then we will disable Laravel's encryption on the cookie
        if ($name !== config('session.cookie') && strpos($name, $this->getPrefix()) === 0) {
            return true;
        }

        return parent::isDisabled($name);
    }

    /**
     * Get the prefix ExpressionEngine is using for its cookie names
     *
     * @return string
     */
    protected function getPrefix()
    {
        return app('ee')->config->item('cookie_prefix') ?: 'exp_';
    }
}
