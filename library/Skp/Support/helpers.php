<?php
function isLogged()
{
    $guard = \Skp\Registry::get('AuthGuard');
    return $guard->check();
}