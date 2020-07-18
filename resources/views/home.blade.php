<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="Shift Financial Insights">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ADS-B Dashboard</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css?') }}{{ uniqid() }}" rel="stylesheet">
    </head>

    <body>

        <div id="app">
            <master></master>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js?') }}{{ uniqid() }}"></script>

        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        </script>
    </body>
</html>
