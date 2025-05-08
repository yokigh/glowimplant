<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css')}}"/>
        <link rel="stylesheet" href="{{url('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css')}}">



    </head>

    <body class="bg-primary bg-pattern">
        @yield('content')


        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <script src="{{url('https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js')}}"></script>
        <!-- Noty JS -->
        <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js')}}"></script>

        <script src="{{asset('assets/js/app.js')}}"></script>
        <script>
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",  // تغيير الموضع
                "preventDuplicates": true,
                "showDuration": "300",  // مدة عرض الرسالة
                "hideDuration": "1000",  // مدة اختفاء الرسالة
                "timeOut": "5000",  // المدة التي ستظل الرسالة فيها مرئية (5 ثوانٍ)
                "extendedTimeOut": "1000"
            };

            document.addEventListener("DOMContentLoaded", function() {
                @if (session('success'))
                    toastr.success("{{ session('success') }}");
                @endif

                @if (session('error'))
                    toastr.error("{{ session('error') }}");
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        toastr.warning("{{ $error }}");
                    @endforeach
                @endif
            });
        </script>

    </body>
</html>
