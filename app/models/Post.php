<?php

use Skp\Validation\Validator;

class Post extends \Illuminate\Database\Eloquent\Model
{

    public static $rules = [
        Validator::RULE_CREATE => [
            'photo' => 'required|image',
            'description' => 'max:140',
        ],
        Validator::RULE_UPDATE => [],
    ];

    public static $messages = [
        'photo.required' => 'Selecione uma imagem',
        'photo.image' => 'Você só pode enviar imagens',
        'description.max' => 'A descrição não pode ter mais de 140 caracteres',
    ];

    public function likes()
    {
        return $this->belongsToMany('User', 'post_likes', 'post_id', 'user_id');
    }

    public function liked(User $user)
    {
        return (bool)PostLikes::where('post_id', $this->id)->where('user_id', $user->id)->count();
    }

    public function like(User $user)
    {

        if (!$this->liked($user)) {

            $like = new PostLikes();
            $like->post_id = $this->id;
            $like->user_id = $user->id;
            $like->save();

        }
    }

    public function unlike(User $user)
    {
        if ($this->liked($user)) {
            PostLikes::where('post_id', $this->id)->where('user_id', $user->id)->delete();
        }
    }

} 