<!-- Web Application Manifest -->
<link rel="manifest" href="{{ route('laravelpwa.manifest') }}" />
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="{{ $config['theme_color'] }}" />

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}" />
<meta name="application-name" content="{{ $config['short_name'] }}" />
<link rel="icon" sizes="{{ data_get(end($config['icons']), 'sizes') }}"
    href="{{ data_get(end($config['icons']), 'src') }}" />

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="{{ $config['display'] == 'standalone' ? 'yes' : 'no' }}" />
<meta name="apple-mobile-web-app-status-bar-style" content="{{ $config['status_bar'] }}" />
<meta name="apple-mobile-web-app-title" content="{{ $config['short_name'] }}" />
<link rel="apple-touch-icon" href="{{ data_get(end($config['icons']), 'src') }}" />


<link href="{{ $config['splash']['640x1136'] }}"
    media="(max-width: 320px) and (max-height: 568px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['750x1334'] }}"
    media="(max-width: 375px) and (max-height: 667px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1242x2208'] }}"
    media="(max-width: 621px) and (max-height: 1104px) and (-webkit-device-pixel-ratio: 3)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1125x2436'] }}"
    media="(max-width: 375px) and (max-height: 812px) and (-webkit-device-pixel-ratio: 3)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['828x1792'] }}"
    media="(max-width: 414px) and (max-height: 896px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1242x2688'] }}"
    media="(max-width: 414px) and (max-height: 896px) and (-webkit-device-pixel-ratio: 3)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1536x2048'] }}"
    media="(max-width: 768px) and (max-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1668x2224'] }}"
    media="(max-width: 834px) and (max-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['1668x2388'] }}"
    media="(max-width: 834px) and (max-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />
<link href="{{ $config['splash']['2048x2732'] }}"
    media="(max-width: 1024px) and (max-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
    rel="apple-touch-startup-image" />

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="{{ $config['background_color'] }}" />
<meta name="msapplication-TileImage" content="{{ data_get(end($config['icons']), 'src') }}" />

<script>
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function(registration) {
            // Registration was successful
            console.log('Rodrigo Brito PWA: ServiceWorker registration successful with scope: ', registration
                .scope);
        }, function(err) {
            // registration failed :(
            console.log('Rodrigo Brito PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>
