<?php

namespace Expressionengine\Coilpack\Auth;

use Expressionengine\Coilpack\Models\Member\Member;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CoilpackUserProvider implements UserProvider
{
    private $model;

    public function __construct($userModel)
    {
        $this->model = $userModel;
    }

    public function retrieveById($identifier)
    {
        return $this->model->find($identifier)->first();
    }

    public function retrieveByCredentials(array $credentials) {
        $check = array_key_exists('username', $credentials) ? 'username' : 'email';
        $check = $credentials[$check];

        return $this->model->query()
            ->where('username', $check)
            ->orWhere('email', $check)
            ->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials) {
        ee()->load->library('auth');

        $hashed = ee()->auth->hash_password($credentials['password']);
        $sess = false;

        if(array_key_exists('username', $credentials))
        {
            $sess = ee()->auth->authenticate_username($credentials['username'], $credentials['password']);
        }

        if(array_key_exists('email', $credentials))
        {
            $sess = ee()->auth->authenticate_email($credentials['email'], $credentials['password']);
        }

        if(!$sess)
        {
            return false;
        }

        $sess->start_session();

        return $sess;
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token) {
        return null;
    }
}
