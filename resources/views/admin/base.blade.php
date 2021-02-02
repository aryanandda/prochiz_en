<?php
    use Facades\ {
        Helper
    };
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="robots" content="noindex">
    <?php /*
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">
    */ ?>
    @section('title')
    <title>{{ config('app.name') }}</title>
    @show

    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/base/assets/css/site.min.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/waves/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/toastr/toastr.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/datatables-fixedheader/dataTables.fixedHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/datatables-responsive/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/multi-select/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/vendor/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/base/assets/examples/css/advanced/lightbox.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/theme/global/fonts/brand-icons/brand-icons.min.css') }}">
    
    
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,300italic">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">

    @section('extraStyle')

    @show

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

    @section('headerExtraScript')

    @show 

</head>
<body @section('bodyClass')  @show >

    @section('topExtraScript')
    @show 

    @include('admin.header')

    @include('admin.sidebar')

    @yield('body')

    @include('admin.footer')

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
    <script src="{{ asset('assets/admin/theme/global/vendor/matchheight/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/datatables-tabletools/dataTables.tableTools.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/multi-select/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>

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


    <script src="{{ asset('assets/admin/theme/global/js/Plugin/select2.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/multi-select.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/config/colors.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/base/assets/js/config/tour.js') }}"></script>
    <script>
    Config.set('assets', '../assets');
    </script>

    <!-- Page -->
    <script src="{{ asset('assets/admin/theme/base/assets/js/Site.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/asscrollable.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/slidepanel.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/switchery.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/matchheight.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/peity.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/global/js/Plugin/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/admin/theme/base/assets/examples/js/advanced/lightbox.js') }}"></script>

    <script src="{{ asset('assets/admin/js/script.js') }}"></script>

    @section('bottomExtraScript')
    @show 
</body>
</html>
