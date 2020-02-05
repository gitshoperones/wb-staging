<!DOCTYPE html>
<!-- secured header -->
<html lang="{{ app()->getLocale() }}">
<head>
    @if (config('app.env') === 'production')
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5SV3VKF');</script>
    <!-- End Google Tag Manager -->
    @endif

    <meta name="robots" content="noindex">
</head>
<body>
    @if (config('app.env') === 'production')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SV3VKF"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    <strong>Email Verified!</strong><br/>
    <strong id="page-info">Preparing to setup your wedBooker profile</strong>

    <script type="text/javascript">
        var el = document.getElementById('page-info'),
            i = 0,
            load = setInterval(function() {
                i = ++i % 4;
                el.innerHTML = 'Preparing to setup your wedBooker profile' + Array(i + 1).join('.');
            }, 600);
        @if (Auth::user()->account === 'vendor')
            redirect('{{ url(sprintf('/vendors/%s', Auth::user()->vendorProfile->id)) }}');
        @else
            redirect('{{ url('/dashboard') }}');
        @endif

        function redirect(url) {
            setTimeout(function(){
                window.location.href = url;
            }, 5000);
        }
    </script>
</body>
</html>
