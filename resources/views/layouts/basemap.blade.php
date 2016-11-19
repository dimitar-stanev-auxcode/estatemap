<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/login-register.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link href="{{asset('/css/material-kit.css')}}" rel="stylesheet"/>

    <!-- Google Fonts: Open Sans -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&amp;subset=cyrillic" rel="stylesheet">
    <!-- Sizing stylesheet -->
    <link href="/css/sizing.css" rel="stylesheet">
    
    <script src="https://maps.googleapis.com/maps/api/js"></script>
     
    @yield('head')
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
        <nav class="navbar navbar-info navbar-top" >
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a  data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();">{{ trans('forms.login') }}</a></li>
                            <li><a data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();">Register</a></li>
                            <div class="modal fade login" id="loginModal">
                              <div class="modal-dialog login animated">
                                  <div class="modal-content">
                                     <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Login with</h4>
                                    </div>
                                    <div class="modal-body">  
                                        <div class="box">
                                             <div class="content">
                                                <div class="social">
                                                    <a class="circle github" href="/auth/github">
                                                        <i class="fa fa-github fa-fw"></i>
                                                    </a>
                                                    <a id="google_login" class="circle google" href="/auth/google_oauth2">
                                                        <i class="fa fa-google-plus fa-fw"></i>
                                                    </a>
                                                    <a id="facebook_login" class="circle facebook" href="/auth/facebook">
                                                        <i class="fa fa-facebook fa-fw"></i>
                                                    </a>
                                                </div>
                                                <div class="division">
                                                    <div class="line l"></div>
                                                      <span>or</span>
                                                    <div class="line r"></div>
                                                </div>
                                                <div class="error"></div>
                                                <div class="form loginBox">
                                                    <form method="post" action="/login" accept-charset="UTF-8">
                                                    {{ csrf_field() }}
                                                    <input id="email" class="form-control" type="text" id="email_input" placeholder="Email" name="email">
                                                    <input id="password" class="form-control" type="password" id="pass_input" placeholder="Password" name="password">
                                                    <input class="btn btn-default btn-login" type="submit" value="Login" >
                                                    </form>
                                                </div>
                                             </div>
                                        </div>
                                        <div class="box">
                                            <div class="content registerBox" style="display:none;">
                                             <div class="form">
                                                <form method="post" html="{:multipart=>true}" data-remote="true" action="/register" accept-charset="UTF-8">
                                                <input id="email" class="form-control" type="text" placeholder="Email" name="email">
                                                <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                                <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                                <input class="btn btn-default btn-register" type="submit" value="Create account" name="commit">
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="forgot login-footer">
                                            <span>Looking to 
                                                 <a href="javascript: showRegisterForm();">create an account</a>
                                            ?</span>
                                        </div>
                                        <div class="forgot register-footer" style="display:none">
                                             <span>Already have an account?</span>
                                             <a href="javascript: showLoginForm();">Login</a>
                                        </div>
                                    </div>        
                                  </div>
                              </div>
                          </div>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <!-- jQuery -->
    <script src="/js/jquery-1.12.3.min.js"></script>
    @if (Auth::guest())
    <script src="/js/bootstrap.js"></script>
    @endif
    <script src="{{asset('/js/material.min.js')}}"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{asset('/js/nouislider.min.js')}}" type="text/javascript"></script>
    <!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
    <script src="{{asset('/js/material-kit.js')}}" type="text/javascript"></script>
    <script src="/js/login-register.js" type="text/javascript"></script>
    <!-- imageLightbox plugin -->
    <script src="/js/imagelightbox.min.js" type="text/javascript"></script>
    @yield('js_footer')
</body>
</html>
