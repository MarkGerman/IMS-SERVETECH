<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('dist/webfont/tabler-icons.min.css') }}">
    @vite(['dist/webfont/tabler-icons.min.css', 'dist/css/style.css', 'plugins/fontawesome-free/css/all.min.css'])


    <!-- Styles -->
    @livewireStyles
</head>

<body class=" ">



    {{ $slot }}



    <footer class="navbar sticky-bottom bg-body border pt-3 ">
        <div class="container d-flex justify-content-between py-3">
            <div class="">
                <b>Version</b> 1.0
            </div>
            <div class="">
                <strong>Copyright &copy; 2014-2025 <a href="http://techlink360.net" class="text-success">Techlink
                        360</a>.</strong> All rights
                reserved.
            </div>
        </div>


    </footer>




    @livewireScripts
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <x-livewire-alert::scripts />

    <script>
        // document.addEventListener('livewire:init', () => {
        Livewire.on('modal-open', (data) => {
            // Handle the event here
            var modalbackdrop = document.createElement('div');
            modalbackdrop.classList.add("modal-backdrop", "fade", "show");
            document.body.appendChild(modalbackdrop);

        });
        Livewire.on('modal-cancel', (data) => {
            // Handle the event here
            var modalbackdrop = document.querySelector('.modal-backdrop');
            if (modalbackdrop) {
                modalbackdrop.parentNode.removeChild(modalbackdrop);
            }

        });
        // });
    </script>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('dist/js/demo.js')}}"></script> --}}
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    @stack('scripts')


</body>

</html>
