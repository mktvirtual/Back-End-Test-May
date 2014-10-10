<?php
namespace Skp\Auth;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserProviderInterface;

class Guard
{

    /**
     * The currently authenticated user.
     *
     * @var UserInterface
     */
    protected $user;

    protected $loggedOut = false;

    public function __construct(UserProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function user()
    {
        if ($this->loggedOut) {
            return;
        }

        if (!is_null($this->user)) {
            return $this->user;
        }

        $id = (isset($_SESSION[$this->getName()])) ? $_SESSION[$this->getName()] : null;

        $user = null;

        if (!is_null($id)) {
            $user = $this->provider->retrieveByID($id);
        }

        return $this->user = $user;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool   $remember
     * @param  bool   $login
     * @return bool
     */
    public function attempt(array $credentials = array(), $login = true)
    {
        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        // If an implementation of UserInterface was returned, we'll ask the provider
        // to validate the user against the given credentials, and if they are in
        // fact valid we'll log the users into the application and return true.
        if ($this->hasValidCredentials($user, $credentials)) {
            if ($login) {
                $this->login($user);
            }

            return true;
        }

        return false;
    }

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        return !is_null($user) && $this->provider->validateCredentials($user, $credentials);
    }

    public function login(UserInterface $user)
    {
        $this->updateSession($user->getAuthIdentifier());

        $this->setUser($user);
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $this->clearUserDataFromStorage();

        $this->user = null;
        $this->loggedOut = true;
    }

    protected function clearUserDataFromStorage()
    {
        unset($_SESSION[$this->getName()]);
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        $this->loggedOut = false;
    }

    /**
     * Update the session with the given ID.
     *
     * @param  string  $id
     * @return void
     */
    protected function updateSession($id)
    {
        $_SESSION[$this->getName()] = $id;
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        return 'login_' . md5(get_class($this));
    }

} 