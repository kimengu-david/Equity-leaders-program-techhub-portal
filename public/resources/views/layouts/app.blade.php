<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{!! csrf_token() !!}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/custom/app.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
    function mailServer() {
        Swal.fire("<b style='color:red' >Mail server is currently down!</b>",
            "We are working on this.",
            "Error");
    }
    </script>
</head>





<body data-spy="scroll" data-target="#navbarResponsive">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="../images/logo/logo.png" />
                    <!--{{ config('app.name', 'Laravel') }}-->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <!-- Left Side Of Navbar -->
                    <!--<ul class="navbar-nav ml-auto">-->

                    <!--</ul>-->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <li class="nav-item">
                            <a class="nav-link" href="/">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#partners">{{ __('Our partners') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#activities">{{ __('Activities') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#about">{{ __('About Us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{'register'}}">{{ __('Join Us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#myModal" data-toggle="modal">{{ __('Login') }}</a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>

        <div id="home" class="landing">
            <div class="home-wrap">
                <div class="home-inner">
                    <img class="img-responsive" src="../images/logo/bg2.jpg" />
                </div>

            </div>

            <div class="caption text-center">

                <h1>The largest team of ELP scholars in Tech</h1>


            </div>

        </div>


        <div id="course" class="offset">
            <div class="col-12 narrow text-center">



            </div>

        </div>

        <!--Start of the activities section.-->
        <div id="activities" class="activites">
            <!--Start of jumbotron-->
            <div class="jumbotron">
                <div class="narrow">
                    <div class="col-12">
                        <h3 class="heading">
                            <center>CATCH UP WITH OUR LATEST ACTIVITIES</center>
                        </h3>
                        <div class="heading-underline"></div>
                    </div>
                    <div class="row text-center">
                        @yield('content1')

                    </div>
                </div>
            </div>

        </div>
        <!--End of the jumbotron-->

        <div id="partners" class="Partners ">
            <!--Start of jumbotron-->
            <div class="jumbotron">

                <div class="col 12 text-center">

                    <h3 class="heading">OUR PARTNERS</h3>
                    <div class="heading-underline"></div>

                </div>
                <!--Start row-->
                <div class="row">
                    <div class="col-md-6 partners">
                        <div class="row">

                            <div class="col-md-4">
                                <img src="../images/partners/testclient1.png">
                            </div>
                            <div class="col-md-8">
                                <blockquote>

                                    <i class="fas fa-quote-left"></i>
                                    Equity bank has been working with the ELP techhub team
                                    and continues to support the team in all its endeavors.
                                    <hr class="partners-hr">

                                    <cite>&#8212; James Mwangi equity bank CE0</cite>
                                </blockquote>

                            </div>
                        </div>



                    </div>
                    <div class="col-md-6 partners">
                        <div class="row">

                            <div class="col-md-4">
                                <img src="../images/partners/testclient3.jpg">
                            </div>
                            <div class="col-md-8">
                                <blockquote>

                                    <i class="fas fa-quote-left"></i>
                                    Equity bank has been working with the ELP techhub team
                                    and continues to support the team in all its endeavors.
                                    <hr class="partners-hr">

                                    <cite>&#8212; James Mwangi equity bank CE0</cite>
                                </blockquote>

                            </div>
                        </div>



                    </div>


                </div>


            </div>

            <div class="md -12 narrow text-left">

                <p class="lead">


                    <h3>
                        <marquee width="90%" direction="left" height="30%">
                            The ELP techhub is a team of "Equity Bank leaders program" scholars in technology and
                            technology related
                            fields. Our goal is to use technology to solve Everyday challenges........ELP techhub is a
                            subsidiary of Equity leaders program
                        </marquee>
                    </h3>
                </P>
            </div>

        </div>
        <!--End row-->

        <div id="about" class="offset">
            <footer>

                <div class="row justify-content-center">

                    <div class="col-md-5 text-center">

                        <img src="../images/logo/logo.png" />
                        <p>
                            The ELP techhub team brings together the largest pool of technology specialists.
                            contact us today.

                        </p>
                        <strong>
                            Contact info
                        </strong>
                        <p>(254)741937028</br>elptechhub@gmail.com</p>
                        <a href="" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="" target="_blank"><i class="fab fa-twitter-square"></i></a>
                        <a href="" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>

                    <hr class="socket">
                    &copy;ELPtechhub.

                </div>
            </footer>


        </div>

    </div>
    <!--End jumbotron-->


    <!-- Modal HTML -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-login">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Member Login</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="login-form" method="post">

                        <div id='alert' class="alert alert-danger" style="display:none"></div>
                        <div class="alert alert-success" style="display:none"></div>

                        <div class="form-group">
                            <i class="custom fa fa-user"></i>
                            <input type="text" class="form-control" name="email" placeholder="Email address"
                                required="required">
                        </div>
                        <div class="form-group">
                            <i class="custom fa fa-lock"></i>
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                required="required">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <a href="#" onclick="mailServer()">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>

    <!--End of login modal-->
    <!--Jquery to be used for making ajax calls-->
    <script>
    $(document).ready(function() {
        //Clearing the modal fields.
        $("#myModal").on('hidden.bs.modal', function() {
            $('#login-form')[0].reset();
            $('.alert-danger').hide()

        })
        //$("#myModal").on('shown.bs.modal', function() {


        // })
    });


    $('#login-form').submit(function(event) {

        event.preventDefault();
        $.ajax({

            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'email': $('input[name=email]').val(),
                'password': $('input[name=password]').val(),

            },

            url: 'post-login',

            success: function(response) {

                window.location.href = response.redirect
            },
            error: function(response) {

                $('.alert-danger').text(response.responseJSON.error)
                $('.alert-danger').show()

            }
        });
    });
    </script>





</body>

</html>