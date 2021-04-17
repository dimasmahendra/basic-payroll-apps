<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | CV SETIAJI SURAKARTA</title>
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <link rel="shortcut icon" href="assets/images/favicon.ico" />
        @section('css')
          <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
          <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
          <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        @show
    </head>
    <body class="account-body accountbg">
        <!-- Register page -->
        <div class="container">
            <div class="row vh-100 d-flex justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box">
                                    @section('title')
                                    <div class="text-center p-3">
                                        <h4 class="mt-3 font-weight-semibold text-white font-18">{{ $title ?? '' }}</h4>
                                        <h5 class="mt-1 mb-4 font-weight-semibold text-muted">{{ $subtitle ?? '' }}</h5>
                                    </div>
                                    @show
                                </div>
                                <div class="card-body">
                                    @section('body')
                                    @show
                                </div>
                                <div class="card-body bg-light-alt text-center" style="padding-top:0; padding-bottom:6px;">
                                    <span class="text-muted d-none d-sm-inline-block">&copy; {{ now()->year }} | CV SETIAJI SURAKARTA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @section('js')
          <script src="/assets/js/jquery.min.js"></script>
          <script src="/assets/js/bootstrap.bundle.min.js"></script>
          <script src="/assets/js/waves.js"></script>
          <script src="/assets/js/feather.min.js"></script>
          <script src="/assets/js/simplebar.min.js"></script>
        @show
    </body>
</html>
