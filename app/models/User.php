<?php

use Skp\Validation\Validator;

class User extends \Illuminate\Database\Eloquent\Model implements \Illuminate\Auth\UserInterface
{

    public static $rules = [
        Validator::RULE_CREATE => [
            'username' => 'required|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ],
        Validator::RULE_UPDATE => [],
    ];

    public static $messages = [
        'username.required' => 'Informe um usuário',
        'username.unique' => 'Esse usuário já está sendo utilizado',
        'email.required' => 'Informe um e-mail',
        'email.email' => 'Informe um e-mail válido',
        'email.unique' => 'Esse e-mail já está sendo utilizado',
        'password.required' => 'Informe uma senha',
        'password.min' => 'Sua senha precisa ter no mínimo 6 caracteres',
    ];

    public function posts()
    {
        return $this->hasMany('Post', 'user_id', 'id');
    }

    public function followers()
    {
        return $this->belongsToMany('User', 'user_followers', 'user_followed_id', 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany('User', 'user_followers', 'user_id', 'user_followed_id');
    }

    public function followed(User $user)
    {
        return (bool)UserFollowers::where('user_id', $this->id)->where('user_followed_id', $user->id)->count();
    }

    public function follow(User $user)
    {

        if (!$this->followed($user)) {

            $follow = new UserFollowers();
            $follow->user_id = $this->id;
            $follow->user_followed_id = $user->id;
            $follow->save();

        }
    }

    public function unfollow(User $user)
    {
        if ($this->followed($user)) {
            UserFollowers::where('user_id', $this->id)->where('user_followed_id', $user->id)->delete();
        }
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }


}