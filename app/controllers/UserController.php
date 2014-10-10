<?php

use Symfony\Component\HttpFoundation\Response;
use Skp\Validation\Validator;

class UserController extends BaseController
{

    public function registerAction()
    {
        if (!isLogged()) {
            return new Response($this->render('user/register.php', []));
        }

        $guard = \Skp\Registry::get('AuthGuard');
        return new \Illuminate\Http\RedirectResponse('/' . $guard->user()->username);
    }

    public function perfilAction($username)
    {
        $user = User::where('username', $username)->first();

        return new Response($this->render('user/perfil.php', [
            'user' => $user
        ]));
    }

    public function followAction($username)
    {
        $response = ['followed' => false];

        if (isLogged()) {

            $user = User::where('username', $username)->first();
            $loggedUser = \Skp\Registry::get('loggedUser');

            if ($user->id != $loggedUser->id) {

                if (!$loggedUser->followed($user)) {
                    $loggedUser->follow($user);

                    $response['followed'] = true;
                } else {
                    $loggedUser->unfollow($user);

                    $response['followed'] = false;
                }

            }

        }

        return new \Symfony\Component\HttpFoundation\JsonResponse($response);
    }

    public function sendRegisterAction()
    {
        if (!$this->request->isMethod('POST') || isLogged()) {
            return new \Illuminate\Http\RedirectResponse('/');
        }

        $data = $this->request->get('form', []);

        $validator = Validator::make(
            $data,
            User::$rules[Validator::RULE_CREATE],
            User::$messages
        );

        if ($validator->fails()) {
            return new Response($this->render('user/register.php', [
                'errors' => $validator->messages(),
                'form'   => $data
            ]));
        }

        $hasher = new \Illuminate\Hashing\BcryptHasher();

        $user = new User();
        $user->username     = $data['username'];
        $user->email        = $data['email'];
        $user->password     = $hasher->make($data['password']);
        $user->confirmed_at = date('Y-m-d H:i:s');
        $user->confirmed    = 1;

        $saved = $user->save();

        if ($saved) {
            $guard = \Skp\Registry::get('AuthGuard');
            $guard->login($user);

            return new \Illuminate\Http\RedirectResponse('/' . $user->username);
        }

        return new Response($this->render('user/register.php', [
            'error' => 'Houve um erro inesperado ao criar sua conta',
            'form'  => $data
        ]));
    }

    public function sendLoginAction()
    {
        if (!$this->request->isMethod('POST') || isLogged()) {
            return new \Illuminate\Http\RedirectResponse('/');
        }

        $data   = $this->request->get('login', []);

        $guard  = \Skp\Registry::get('AuthGuard');
        $logged = $guard->attempt($data);

        if (!$logged) {
            return new Response($this->render('user/register.php', [
                'error' => 'Usuário e/ou senha inválido(s)',
                'login' => $data
            ]));
        }

        $user = $guard->user();

        return new \Illuminate\Http\RedirectResponse('/' . $user->username);
    }

    public function logoutAction()
    {
        $guard = \Skp\Registry::get('AuthGuard');
        $guard->logout();

        return new \Illuminate\Http\RedirectResponse('/');
    }

}