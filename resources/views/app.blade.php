<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Libreria COQUITO</title>
    <!-- General CSS Files -->


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">

    <link rel="stylesheet" href="{{asset('/vendors/iconly/bold.css')}}">

    <link rel="stylesheet" href="{{asset('/vendors/perfect-scrollbar/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('/vendors/bootstrap-icons/bootstrap-icons.css')}}">

    <link rel="stylesheet" href="{{asset('/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('/vendors/jquery-datatables/dataTables.select.min.css')}}">

    <link rel="stylesheet" href="{{asset('/vendors/vue-select/vue-select.min.css')}}">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @routes
    @inertiaHead

</head>

<body>
    @inertia

    <script src="{{asset('/vendors/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('/vendors/apexcharts/apexcharts.js')}}"></script>
    <script src="{{asset('/js/pages/dashboard.js')}}"></script>

    <script src="{{asset('/vendors/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('/vendors/moment/moment-with-locales.min.js')}}"></script>

    <script src="{{asset('/vendors/jquery-datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/vendors/jquery-datatables/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js')}}"></script>

    <script src="{{asset('/vendors/vue-select/vue-select.min.js')}}"></script>

</body>

</html>
