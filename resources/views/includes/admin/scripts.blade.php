    <script  src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script data-navigate-once src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.4.3/js/tom-select.complete.min.js"></script>

        {{-- Froala JS must be included via CDN script tag --}}
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@4.1.2/js/froala_editor.pkgd.min.js'></script>

    <script  src="{{ asset('assets/admin/lib/chart/chart.min.js') }}"></script>
    <script  src="{{ asset('assets/admin/lib/easing/easing.min.js') }}"></script>
    <script  src="{{ asset('assets/admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script  src="{{ asset('assets/admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script  src="{{ asset('assets/admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script  src="{{ asset('assets/admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script  src="{{ asset('assets/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script  src="{{ asset('assets/admin/js/main.js') }}"></script>

    @yield('scripts')  {{-- ✅ CORRECT POSITION: Livewire scripts MUST be loaded after all dependencies. --}}
    @livewireScripts

    </body>

</html>
