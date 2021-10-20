<!-- Global site tag (gtag.js) - Google Analytics -->
@if(!App::environment('local') && env('APP_DEBUG') == false)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_KEY') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ env('GA_KEY') }}');
    </script>
@endif
