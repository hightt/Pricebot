<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pricebot</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
</head>

<body>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/jQuery-3.6.0/jquery-3.6.0.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/DataTables-1.12.1/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Responsive-2.3.0/js/dataTables.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Buttons-2.2.3/js/buttons.colVis.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            });


        });

        function showMessage(message = "", status = "") {
            $('#msg').addClass('alert-' + status).show();
            $('#msg').children('span').text(message);
            $('#msg').delay(2000).fadeOut('slow');
        }
    </script>


    <div id="msg" class="alert msg-alert" role="alert" style="display:none;">
        <span></span>
    </div>

    @if (Session::has('alert'))
    <?php
    $msg = Illuminate\Support\Facades\Session::get('alert');
    Illuminate\Support\Facades\Session::forget('alert');
    ?>
    <script>
        showMessage("{{$msg['message']}}", "{{$msg['status']}}")
    </script>

    @endif
    <div class="container">
        <div class="row">
            @include('layouts.header')
        </div>
        <div class="row">
            @yield('content')
        </div>
        <div class="row">
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>