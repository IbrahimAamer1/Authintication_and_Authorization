<!-- Core JS -->
<script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/js/menu.js"></script>

<!-- Vendors JS -->
<script src="{{ asset($assetsPath ?? 'assets-back') }}/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{ asset($assetsPath ?? 'assets-back') }}/js/main.js"></script>

<!-- Page JS -->
@stack('scripts')

<!-- GitHub Buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

