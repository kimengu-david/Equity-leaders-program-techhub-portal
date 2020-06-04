@extends('layouts.app')

@section('content')
<div class='container'>
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{$post->image}}" class="w-100" alt="">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex">
                    <div class="pr-3">
                        <img src="{{$post->user->profile->profileImage()}}" class="w-50 rounded-circle">
                        <div class="font-weight-bold"><a href="/profile/ {{$post->user->id}}">
                                <span class="text-dark">
                                    {{$post->user->username}}</a>
                            </span>
                        </div>
                        <a href="">Follow</a>
                    </div>
                    <!--
                        This line of code had alignment issues of the username(to be checked.)
                    <div>

                        <p class="font-weight-bold"> {{$post->user->username}}<p>
                    </div>
-->
                </div>
                <hr>
                <!--Is the horizontal rule-->
                <p>{{$post->caption}}</p>
            </div>
        </div>
    </div>
</div>
@endsection