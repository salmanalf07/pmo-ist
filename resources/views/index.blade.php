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
    <!-- datatable -->
    <link href="/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/assets/css/daterangepicker/daterangepicker.css">
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- dragula -->
    <link href="/assets/libs/dragula/dist/dragula.min.css" rel="stylesheet">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="/assets/css/theme.min.css">
    <title>PMO PORTAL</title>
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

    <!-- dragula -->
    <script src="/assets/libs/dragula/dist/dragula.min.js"></script>
    <!-- Libs JS -->
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/feather-icons/dist/feather.min.js"></script>
    <script src="/assets/libs/simplebar/dist/simplebar.min.js"></script>
    <!-- flatpickr -->
    <script src="/assets/libs/flatpickr/dist/flatpickr.min.js"></script>
    <!-- quill js -->
    <script src="/assets/libs/quill/dist/quill.min.js"></script>
    <!-- daterangepicker -->
    <script src="/assets/css/moment/moment.min.js"></script>
    <script src="/assets/css/daterangepicker/daterangepicker.js"></script>


    <!-- Theme JS -->
    <script src="/assets/js/theme.min.js"></script>
    <script src="/assets/libs/jsvectormap/dist/js/jsvectormap.min.js"></script>
    <script src="/assets/libs/jsvectormap/dist/maps/world.js"></script>
    <script src="/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="/assets/js/vendors/chart.js"></script>

    <!-- datatable -->
    <script src="/assets/libs/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/js/vendors/datatable.js"></script>

    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- ribuan -->
    <script src="/assets/js/ribuan.js"></script>
    <script src="/assets/js/formatNumber.js"></script>
    <script src="/assets/css/moment/moment.min.js"></script>
    <script>
        function addPercentage(inputField) {
            var inputValue = inputField.value;
            var numberOnly = inputValue.replace(/[^0-9,.]/g, '');
            var formattedValue = numberOnly.replace(/,/g, '.');
            // console.log(formattedValue)

            if (parseFloat(formattedValue) > 100) {
                alert("Angka melebihi 100!");
                inputField.value = '0' + '%';
                $(inputField).trigger('input');
            } else {
                inputField.value = formattedValue + '%';
                $(inputField).trigger('input');
            }
        }

        function convertToDate(dateString) {
            var parts = dateString.split("-");
            var day = parseInt(parts[0]);
            var month = parseInt(parts[1]) - 1; // Januari adalah bulan 0 dalam objek Date
            var year = parseInt(parts[2]);
            var date = new Date(year, month, day);
            return date;
        }
    </script>


</body>

</html>