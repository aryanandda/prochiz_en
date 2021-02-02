<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="author" content="Pentacode Digital">
        <meta name="robots" content="noindex">
        <title>{{ config('app.name') }}</title>
        <!--
        <link rel="apple-touch-icon" href="{{ asset('assets/admin/theme/base/assets/images/apple-touch-icon.png') }}">
        <link rel="shortcut icon" href="{{ asset('assets/admin/theme/base/assets/images/favicon.ico') }}">
        -->
        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/css/bootstrap-extend.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/base/assets/css/site.min.css') }}">
        <!-- Plugins -->
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/animsition/animsition.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/asscrollable/asScrollable.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/switchery/switchery.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/intro-js/introjs.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/slidepanel/slidePanel.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/flag-icon-css/flag-icon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/waves/waves.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/login.css') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/fonts/material-design/material-design.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/fonts/brand-icons/brand-icons.min.css') }}">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <!--[if lt IE 9]>
        <script src="{{ asset('assets/admin/theme/global/vendor/html5shiv/html5shiv.min.js') }}"></script>
        <![endif]-->
        <!--[if lt IE 10]>
        <script src="{{ asset('assets/admin/theme/global/vendor/media-match/media.match.min.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/respond/respond.min.js') }}"></script>
        <![endif]-->
        <!-- Scripts -->
        <script src="{{ asset('assets/admin/theme/global/vendor/breakpoints/breakpoints.js') }}"></script>
        <script>
            Breakpoints();
        </script>
    </head>
    <body class="animsition page-login-v3 layout-full">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Page -->
        <div class="page vertical-align text-xs-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
            >
            <div class="page-content vertical-align-middle">
                <div class="panel">
                    <div class="panel-body">
                        <div class="brand">
                            <img class="brand-img" src="{{ asset('assets/admin/img/logo.png') }}" alt="{{ config('app.name') }}">
                        </div>

                        {!! Form::open(['url' => route('admin.dologin'), 'method' => 'post', 'autocomplete' => 'off']) !!}

                            <?php 
                                $messages = \Session::get('fail');
                            ?>
                            @if(!empty($messages))
                                <div role="alert" class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    <span class="sr-only">Close</span>
                                </button>Email or password is incorrect</div>
                            @endif

                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input type="email" class="form-control" name="email" autocomplete="off" />
                                <label class="floating-label">Email</label>
                            </div>
                            <div class="form-group form-material floating" data-plugin="formMaterial">
                                <input type="password" class="form-control" name="password" autocomplete="off" />
                                <label class="floating-label">Password</label>
                            </div>
                            <div class="form-group clearfix">
                                <div class="checkbox-custom checkbox-inline checkbox-success checkbox-lg pull-xs-left">
                                    <input type="checkbox" id="inputCheckbox" name="remember">
                                    <label for="inputCheckbox">Remember me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block m-t-40">Sign in</button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <footer class="page-copyright page-copyright-inverse">
                    <p>PROCHIZ</p>
                    <p>© 2017. All RIGHT RESERVED.</p>
                </footer>
            </div>
        </div>
        <!-- End Page -->
        <!-- Core  -->
        <script src="{{ asset('assets/admin/theme/global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/tether/tether.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/bootstrap/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/animsition/animsition.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/waves/waves.js') }}"></script>
        <!-- Plugins -->
        <script src="{{ asset('assets/admin/theme/global/vendor/switchery/switchery.min.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/intro-js/intro.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/screenfull/screenfull.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
        <!-- Scripts -->
        <script src="{{ asset('assets/admin/theme/global/js/State.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Component.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Plugin.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Base.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Config.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/base/assets/js/Section/Menubar.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/base/assets/js/Section/GridMenu.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/base/assets/js/Section/Sidebar.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/base/assets/js/Section/PageAside.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/base/assets/js/Plugin/menu.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/config/colors.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/base/assets/js/config/tour.js') }}"></script>
        <script>
            Config.set('assets', '{{ asset('assets/admin/theme/base/assets') }}');
        </script>
        <!-- Page -->
        <script src="{{ asset('assets/admin/theme/base/assets/js/Site.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Plugin/asscrollable.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Plugin/slidepanel.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Plugin/switchery.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Plugin/jquery-placeholder.js') }}"></script>
        <script src="{{ asset('assets/admin/theme/global/js/Plugin/material.js') }}"></script>
        <script>
            (function(document, window, $) {
              'use strict';
              var Site = window.Site;
              $(document).ready(function() {
                Site.run();
              });
            })(document, window, jQuery);
        </script>
    </body>
</html>