<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Complaint</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/unmul.png') }}" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/hope-ui.min.css?v=1.2.0') }}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css?v=1.2.0') }}" />

    {{-- My Css --}}
    @stack('my-css')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->

    {{-- Sidebar --}}
    <x-partials.sidebar />
    {{-- End Sidebar --}}

    <main class="main-content">
        <div class="position-relative iq-banner">
            {{-- Navbar --}}
            {{-- Tobar --}}
            <x-partials.topbar />
            {{-- End Topbar --}}
            {{-- Jumbutron --}}
            <x-partials.jumbutron />
            {{-- End Jumbutron --}}
            {{-- End Navbar --}}
        </div>
        <div class="conatiner-fluid content-inner mt-n5 py-0">
            <div class="row">
                <div class="col-sm-12">
                    {{-- Content --}}
                    {{ $slot }}
                    {{-- EndContent --}}
                </div>
            </div>
        </div>
        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body">
                <ul class="left-panel list-inline mb-0 p-0">
                    <li class="list-inline-item"><a href="https://ft.unmul.ac.id/">Fakultas Teknik</a>
                    </li>
                    <li class="list-inline-item"><a href="http://si.ft.unmul.ac.id/">Sistem Informasi</a>
                    </li>
                </ul>
                <div class="right-panel">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Indra Wijaya, Sistem Informasi
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>
    <!-- Wrapper End-->

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/js/hope-ui.js') }}" defer></script>

    {{-- My Javascript --}}
    @stack('my-js')
</body>

</html>
