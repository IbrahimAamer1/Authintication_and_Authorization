<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets-back') }}/" data-template="vertical-menu-template-free">

    @php
        $assetsPath = 'assets-back';
    @endphp
    @include('partials.shared.head')

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('partials.back.sidebar')

                <!-- Layout container -->
                <div class="layout-page">
                    @include('partials.back.navbar')

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @include('partials.shared.alerts')
                            @include('partials.back.breadcrumbs')
                            @yield('content')
                        </div>
                        <!-- / Content -->

                        @include('partials.back.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        @include('partials.shared.modals.mainModal')
        @include('partials.shared.modals.deleteModal')

        @php
            $assetsPath = 'assets-back';
        @endphp
        @include('partials.shared.scripts')
    </body>
</html>

