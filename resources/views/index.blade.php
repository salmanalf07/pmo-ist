<!DOCTYPE html>
<html lang="en" data-layout=horizontal>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Codescandy">


    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon/favicon.ico">


    <!-- Libs CSS -->
    <link href="/assets/libs/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/assets/libs/simplebar/dist/simplebar.min.css" rel="stylesheet">



    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.min.css">
    <title>PMO-IST</title>
</head>

<body>
    <main id="main-wrapper" class="main-wrapper">


        @include('partials/header')
        <!-- navbar horizontal -->
        <!-- navbar -->
        @include('partials/navbar-horizontal')

        @yield('konten')
    </main>
    <!-- Scripts -->


    <!-- Libs JS -->
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/feather-icons/dist/feather.min.js"></script>
    <script src="/assets/libs/simplebar/dist/simplebar.min.js"></script>




    <!-- Theme JS -->
    <script src="/assets/js/theme.min.js"></script>
    <script src="/assets/libs/jsvectormap/dist/js/jsvectormap.min.js"></script>
    <script src="/assets/libs/jsvectormap/dist/maps/world.js"></script>
    <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="/assets/js/vendors/chart.js"></script>



</body>

</html>