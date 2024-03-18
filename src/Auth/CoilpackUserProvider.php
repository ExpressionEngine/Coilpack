<?php

namespace Expressionengine\Coilpack\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class CoilpackUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $key = array_key_exists('username', $credentials) ? 'username' : 'email';
        $value = $credentials[$key];

        return $this->newModelQuery()
            ->where('username', $value)
            ->when(strpos($value, '@'), function ($query) use ($value) {
                $query->orWhere('email', $value);
            })
            ->first();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        ee()->load->library('auth');

        $result = false;

        if (array_key_exists('username', $credentials)) {
            $result = ee()->auth->authenticate_username($credentials['username'], $credentials['password']);
        } elseif (array_key_exists('email', $credentials)) {
            $result = ee()->auth->authenticate_email($credentials['email'], $credentials['password']);
        }

        if (! $result) {
            return false;
        }

        $result->start_session();

        return $result !== false;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        if (! ee()->remember->exists()) {
            return null;
        }

        $model = $this->createModel();

        return $this->newModelQuery($model)->where(
            $model->getAuthIdentifierName(),
            ee()->remember->data('member_id')
        )->first();
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        ee()->remember->exists() ? ee()->remember->refresh() : ee()->remember->create();
    }
}
