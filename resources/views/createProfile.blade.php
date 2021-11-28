@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <form action="{{ empty($profile) ? route('profile.postCreate') : route('profile.postEdit') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description"
                            value="{{ empty($profile) ? '' : $profile->description }}">
                    </div>

                    <div class="form-group row">
                        <label for="profilepic">Profile picture</label><br />
                        <input type="file" name="profilepic" id="profilepic">
                    </div>

                    <div class="form-group row">
                        <label for="bgpic">Background picture</label><br />
                        <input type="file" name="bgpic" id="bgpic">
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">{{ empty($profile) ? 'Create' : 'Edit'}} profile</button>
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection