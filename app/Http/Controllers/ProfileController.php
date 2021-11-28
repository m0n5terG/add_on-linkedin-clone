<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;


class ProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        $profile = Profile::where('user_id', $user->id)->first();
        $posts = \App\Models\Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $postscount = \App\Models\Post::where('user_id', $user->id)->count();

            return view('profile', [
                'user' => $user,
                'profile' => $profile,
            'posts' => $posts,
            'postscount' => $postscount
        ]);
    }

    public function create() {
        return view('createProfile');
    }

    public function postCreate() {
        $data = request()->validate([
            'description' => 'required',
            'profilepic' => ['required', 'image'],
            'bgpic' => ['required', 'image']
        ]);

        // store the image in uploads, under public
        // request(‘profilepic’) is like $_GET[‘profilepic’]
        $imagePath = request('profilepic')->store('uploads', 'public');
        $bgPath = request('bgpic')->store('uploads', 'public');

        // create a new profile, and save it
        $user = Auth::user();
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->description = request('description');
        $profile->image = $imagePath;
        $profile->background = $bgPath;
        $saved = $profile->save();

        // if it saved, we send them to the profile page
        if ($saved) {
            return redirect('/profile');
        }
        
    }

    public function postEdit() {
        $data = request()->validate([
            'description' => 'required',
            'profilepic' => 'image',
            'bgpic' => 'image'
        ]);

        // Load the existing profile
        $user = Auth::user();
        
        //this is empty and returning null
        $profile = Profile::where('user_id', $user->id)->first();
        if(empty($profile)){
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->description = request('description');

        // Save the new profile pic... if there is one in the request()!
        if (request()->has('profilepic')) {
            $imagePath = request('profilepic')->store('uploads', 'public');
            $profile->image = $imagePath;
        }

         // Save the new bg pic... if there is one in the request()!
         if (request()->has('bgpic')) {
            $bgPath = request('bgpic')->store('uploads', 'public');
            $profile->background = $bgPath;
        }

        // Now, save it all into the database
        $updated = $profile->save();
        if ($updated) {
            return redirect('/profile');
        }
    }


    public function edit() {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('createProfile', [
            'profile' => $profile
        ]);
    }


    public function update(){
        $data = request()->validate([
            'description' => 'required',
            'profilepic' => 'image',
            'bgpic' => 'image'
        ]);
    
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
    }
    

}