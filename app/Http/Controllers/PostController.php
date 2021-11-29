<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("post.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'caption' => 'required',
            'postpic' => ['required', 'image'],
        ]);

        $user = Auth::user();
        $post = new Post();
        $imagePath = request('postpic')->store('uploads', 'public');

        $post->user_id = $user->id;
        $post->title = request('title');;
        $post->caption = request('caption');
        $post->image = $imagePath;
        $saved = $post->save();

        if ($saved) {
            return redirect('/profile');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = Post::where('id', $post->id)->first();
        $user = Auth::user();
        
        return view('post.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view("post.create", [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = request()->validate([
            'title' => 'required',
            'caption' => 'required',
            'postpic' => 'image'
        ]);

        // Load the existing profile
        $user = Auth::user();
        
        //this is empty and returning null
        $post = Post::where('id', $post->id)->first();
        if(empty($post)){
            $post = new Post();
            $post->user_id = $user->id;
        }

        $post->title = request('title');
        $post->caption = request('caption');

        // Save the new image... if there is one in the request()!
        if (request()->has('postpic')) {
            $imagePath = request('postpic')->store('uploads', 'public');
            $post->image = $imagePath;
        }

        // Now, save it all into the database
        $updated = $post->save();
        if ($updated) {
            return redirect('/profile');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($postID)
    {
        $post = Post::where('id', $postID)->first();
        $post->delete();
        return redirect('/profile');
    }
}
