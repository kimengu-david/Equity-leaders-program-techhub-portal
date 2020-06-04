<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />

</head>

<body>
    <div class='container'>
        <form action="/p" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="row">
                        <h1>Create new post</h1>
                    </div>

                    <div class="form-group row">
                        <label for="caption" class="col-md-4 col-form-label ">post caption</label>


                        <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror"
                            name="caption" value="{{ old('caption') }}" required autocomplete="caption" autofocus>

                        @if($errors->has('caption'))
                        <strong> {{$errors->first('caption')}} </strong>

                        @endif


                    </div>
                    <div class="row">
                        <label for="image" class="col-md-4 col-form-label ">Post Image</label>
                        <input type="file" ,class="form-control-file" id="image" name="image">
                        @if($errors->has('image'))
                        <strong> {{$errors->first('image')}} </strong>

                        @endif

                    </div>
                    <div class="row pt-4">
                        <button class="btn btn-primary">Add New Post</button>
                    </div>
                </div>
            </div>


        </form>

    </div>
</body>

</html>