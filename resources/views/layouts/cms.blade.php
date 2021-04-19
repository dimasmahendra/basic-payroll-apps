<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{isset($title) ? $title : ""}} | SETI-AJI</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/jquery-ui.min.css" rel="stylesheet" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/plugins/toastify/toastify.css">
    <link href="/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/seti-aji.css" rel="stylesheet" type="text/css" />
    @stack('css-plugins')
</head>

<body class="">
    @include('components.sidebar')
    <div class="page-wrapper">
        @include('components.topbar')
        <div class="page-content">
            <div class="container-fluid">
                @include('components.breadcrumb')
                <div class="row">
                    <div class="col-lg-12">
                        @include('components.alert')
                        @yield('content')
                    </div>
                </div>
            </div>
            <footer class="footer text-center text-sm-left">
                &copy; {{ now()->year }} | CV SETIAJI SURAKARTA
            </footer>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/metismenu.min.js"></script>
    <script src="/assets/js/waves.js"></script>
    <script src="/assets/js/feather.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/pages/jquery.datatable.init.js"></script>
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="/assets/js/maskmoney.js"></script>
    <script src="/plugins/toastify/toastify.js"></script>
    <script src="/assets/js/moment.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/seti-aji.js"></script>
    @stack('js-plugins')
    @if(Session::has('message'))
        <script>
            Toastify({
                text: "<?=Session::get('message')?>",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4fbe87",
            }).showToast();
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            Toastify({
                text: "<?=Session::get('error')?>",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#f3616d",
            }).showToast();
        </script>
    @endif
</body>

</html>
