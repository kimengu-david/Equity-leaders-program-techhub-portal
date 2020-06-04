@extends('layouts.app')

@section('content')
<div class='container'>

    @foreach($posts as $post)

    <div class="row">
        <div class="col-6 offset-4">
            <a href="/profile/{{$post->user->id}}">
                <img src="/storage/{{$post->image}}" class="w-100" alt="">
            </a>

        </div>
    </div>
    <div class="row pt-2 pb-4">

        <div class="col-6 offset-4">
            <div>
                <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{$post->user->id}}">
                            <span class="text-dark">{{$post->user->username}}</span>
                        </a>
                    </span>{{$post->caption}}
                </p>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <!--The links method gets called whenever we add the pagination in the controller.-->
            {{$posts->links()}}
        </div>
    </div>
</div>
@endsection