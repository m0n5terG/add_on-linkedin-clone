@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 card" style="padding: 20px">
                <h4 style="border-bottom: 1px solid grey;padding-bottom: 10px;">{{ empty($post) ? 'Create' : 'Edit' }} your Post</h4>
                <form action="{{ empty($post) ? route('post.store') : '/post/editPost/' }}{{ empty($post) ? '' : $post->id }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input class="form-control" type="text" name="title" id="title" placeholder="Title" style="margin: 20px 0"
                        value="{{ empty($post) ? '' : $post->title }}">
                    <textarea class="form-control" name="caption" id="title"
                        placeholder="Caption" style="resize: none;margin: 20px 0">{{ empty($post) ? '' : $post->caption }}</textarea>

                    <label for="postpic">Attach a picture</label>
                    <input type="file" name="postpic" id="postpic">

                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">{{ empty($post) ? 'Post' : 'Save'}}!</button>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection