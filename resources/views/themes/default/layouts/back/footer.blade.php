<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div
            class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                <a href="https://dp-soft.com" target="_blank"
                    class="footer-link">dp soft</a>
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="{{ env('license_url') }}" class="footer-link me-4"
                    target="_blank">License</a>
                <a href="{{ env('more_systems_url') }}" target="_blank" class="footer-link me-4">More
                    Systems</a>

                <a href="{{ env('docs_url') }}" target="_blank" class="footer-link me-4">Documentation</a>

                <a href="{{ env('support_url') }}" target="_blank"
                    class="footer-link d-none d-sm-inline-block">Support</a>
            </div>
        </div>
    </div>
</footer>