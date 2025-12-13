<head>
    @include('partials.shared.meta')

    <title>@yield('title', config('app.name', 'E-Learning Platform'))</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset($assetsPath ?? 'assets-back') }}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset($assetsPath ?? 'assets-back') }}/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset($assetsPath ?? 'assets-back') }}/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset($assetsPath ?? 'assets-back') }}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset($assetsPath ?? 'assets-back') }}/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset($assetsPath ?? 'assets-back') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset($assetsPath ?? 'assets-back') }}/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/js/helpers.js"></script>

    <!-- Config -->
    <script src="{{ asset($assetsPath ?? 'assets-back') }}/js/config.js"></script>
</head>

