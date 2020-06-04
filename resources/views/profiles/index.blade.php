@extends('layouts.app')

@section('content1')

<div class="container">

    <div class="row">

    </div>
    <div class="row pt-5">
        @foreach($posts as $post)
        <div class="col-md-4 pb-4">
            <!--Initially this was a link but I removed it-->
            <!--<a href="/p/{{$post->id}}">-->
            <img src="https://davikani.s3.eu-west-3.amazonaws.com/postuploads/{{$post->image}}" class="w-100">
            <b>{{$post->caption}}</b>
            <!--</a>-->

        </div>
        @endforeach
    </div>
</div>
@endsection