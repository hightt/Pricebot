<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/AutoFill-2.4.0/css/autoFill.bootstrap5.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/Buttons-2.2.3/css/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/ColReorder-1.5.6/css/colReorder.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/DateTime-1.1.2/css/dataTables.dateTime.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/FixedColumns-4.1.0/css/fixedColumns.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/FixedHeader-3.2.4/css/fixedHeader.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/KeyTable-2.7.0/css/keyTable.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/Responsive-2.3.0/css/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/RowGroup-1.2.0/css/rowGroup.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/RowReorder-1.2.8/css/rowReorder.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/Scroller-2.0.7/css/scroller.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/SearchBuilder-1.3.4/css/searchBuilder.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/SearchPanes-2.0.2/css/searchPanes.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/Select-1.4.0/css/select.bootstrap5.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/DataTables/StateRestore-1.1.1/css/stateRestore.bootstrap5.css') }}" />
</head>

<body>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/jQuery-3.6.0/jquery-3.6.0.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/DataTables-1.12.1/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/DataTables-1.12.1/js/dataTables.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Responsive-2.3.0/js/dataTables.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Responsive-2.3.0/js/responsive.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/AutoFill-2.4.0/js/dataTables.autoFill.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/AutoFill-2.4.0/js/autoFill.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Buttons-2.2.3/js/dataTables.buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Buttons-2.2.3/js/buttons.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Buttons-2.2.3/js/buttons.colVis.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/ColReorder-1.5.6/js/dataTables.colReorder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/DateTime-1.1.2/js/dataTables.dateTime.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/FixedColumns-4.1.0/js/dataTables.fixedColumns.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/FixedHeader-3.2.4/js/dataTables.fixedHeader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/KeyTable-2.7.0/js/dataTables.keyTable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/RowGroup-1.2.0/js/dataTables.rowGroup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/RowReorder-1.2.8/js/dataTables.rowReorder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Scroller-2.0.7/js/dataTables.scroller.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/SearchBuilder-1.3.4/js/dataTables.searchBuilder.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/SearchBuilder-1.3.4/js/searchBuilder.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/SearchPanes-2.0.2/js/dataTables.searchPanes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/SearchPanes-2.0.2/js/searchPanes.bootstrap5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/Select-1.4.0/js/dataTables.select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/StateRestore-1.1.1/js/dataTables.stateRestore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libraries/DataTables/StateRestore-1.1.1/js/stateRestore.bootstrap5.js') }}"></script>


    <div class="container">
        @yield('content')
    </div>

</body>

</html>
