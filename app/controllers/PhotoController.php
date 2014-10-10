<?php

use Symfony\Component\HttpFoundation\Response;
use Skp\Validation\Validator;
use Intervention\Image\ImageManager;

class PhotoController extends BaseController
{

    public function addAction()
    {
        if (!isLogged()) {
            return new Response($this->render('user/register.php', []));
        }

        return new Response($this->render('photo/add.php', []));
    }

    public function sendPhotoAction()
    {
        if (!$this->request->isMethod('POST') || !isLogged()) {
            return new \Illuminate\Http\RedirectResponse('/');
        }

        /**
         * @var \Symfony\Component\HttpFoundation\File\UploadedFile $photo
         */
        $photo = $this->request->files->get('photo', null);
        $data  = $this->request->get('form', []);

        $data['photo'] = $photo;

        $validator = Validator::make(
            $data,
            Post::$rules[Validator::RULE_CREATE],
            Post::$messages
        );

        if ($validator->fails()) {
            return new Response($this->render('photo/add.php', [
                'errors' => $validator->messages(),
                'form'   => $data
            ]));
        }

        $guard = \Skp\Registry::get('AuthGuard');
        $user  = $guard->user();

        $post = new Post();
        $post->user_id = $user->id;
        $post->description = (isset($data['description'])) ? $data['description'] : '';

        $saved = $post->save();

        if ($saved) {

            $path = POOL_PATH . 'photos/' . $post->id . '/';

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $fileName = $photo->getClientOriginalName();

            if (file_exists($path . $fileName)) {
                unlink($path . $fileName);
            }

            if (file_exists($path . 'thumb_' . $fileName)) {
                unlink($path . 'thumb_' . $fileName);
            }

            try {

                $photo->move($path, $fileName);

                $manager = new ImageManager();
                $manager->make($path . $fileName)->fit(640, 640)->save($path . $fileName);

                $manager->make($path . $fileName)->fit(306, 306)->save($path . 'thumb_' . $fileName);

                $post->name = $fileName;
                $post->save();

                return new \Illuminate\Http\RedirectResponse('/' . $user->username);

            } catch (Exception $e) {
                echo $e->getMessage();exit;
            }
        }

        if ($post->id) {
            $post->delete();
        }

        return new Response($this->render('photo/add.php', [
            'error' => 'Houve um erro inesperado ao adicionar a foto',
            'form'  => $data
        ]));
    }

    public function listAction($username)
    {
        $user = User::where('username', $username)->first();

        $photos = [];
        $last   = false;

        if ($user) {

            $perPage = 9;
            $total   = $user->posts->count();

            $pages   = ceil($total / $perPage);
            $page    = $this->request->get('page', 1);
            $page    = ($page < 1) ? 1 : $page;
            $page    = ($page > $pages) ? $pages : $page;
            $offset  = $perPage * ($page - 1);

            $photos = $user->posts()->offset($offset)->take($perPage)->get();
            $last   = (bool)($page == $pages);
        }

        $this->layout = null;
        return new Response($this->render('photo/list.php', [
            'photos' => $photos,
            'last' => $last,
            'loggedUser' => \Skp\Registry::get('loggedUser')
        ]));
    }

    public function likeAction($id)
    {
        $response = ['liked' => false];

        if (isLogged()) {

            $photo      = Post::find($id);
            $loggedUser = \Skp\Registry::get('loggedUser');

            if (!$photo->liked($loggedUser)) {
                $photo->like($loggedUser);

                $response['liked'] = true;
            } else {
                $photo->unlike($loggedUser);

                $response['liked'] = false;
            }

            $response['likes'] = $photo->likes()->count();

        }

        return new \Symfony\Component\HttpFoundation\JsonResponse($response);
    }

}