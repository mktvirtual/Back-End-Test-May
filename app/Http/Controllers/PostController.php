<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $posts = Post::where('user_id', $userId);
        return response()->json($posts->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contents = $request->get('photo');

        $photo = Image::make($contents);
        $photo->resize(640, 480, function ($constraint) {
            $constraint->aspectRatio();
        });

        $hash = md5($photo->__toString());
        $title = "{$hash}.jpg";

        Storage::disk('public')->put($title, $photo->stream('jpg'));

        $post = new Post([
            'user_id' => $request->user()->id,
            'image' => Storage::disk('public')->url($title),
            'title' => $title
        ]);
        $post->save();

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        Storage::disk('public')->delete($post->title);

        $post->delete();
        return response()->json('Exculído com sucesso');
    }
}
