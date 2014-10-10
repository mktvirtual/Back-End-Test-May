<?php
namespace Skp\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Hashing\BcryptHasher;
use Skp\Plugin\PluginAbstract;
use Skp\Registry;

class AuthPlugin extends PluginAbstract
{

    public function register()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $guard = new Guard(new EloquentUserProvider(new BcryptHasher(), 'User'));
        Registry::set('AuthGuard', $guard);

        if ($guard->check()) {
            Registry::set('loggedUser', $guard->user());
        }
    }

} 