<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="title" content="{{ setting("seo_title", "") }}">
    <meta name="description" content="{{ setting("seo_description", "") }}">
    <meta name="description" content="{{ setting("seo_keywords", "") }}">
    <meta name="description" content="{{ setting("seo_og_image", "") }}">
    <meta name="format-detection" content="telephone=no, address=no, email=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/assets/images/favicon.ico">
    <title>{{ setting("site_name", "Rinnai") }}</title>
    {{ $head }}
    <!-- Scripts -->
    @vite(['resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- /resources -->

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8S1XL4NXCG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-8S1XL4NXCG');
    </script>
</head>

<body id="corp">
<a class="visually-hidden-focusable" href="#mainContent">Skip to content</a>
<!-- [ HEADER ] -->
<x-front.header />
<!-- [ /HEADER ] -->

{{ $slot }}

<!-- [ FOOTER ] -->
<x-front.footer />
<!-- [ /FOOTER ] -->

<script>new ScrollHint('.scroll');</script>

</body>

</html>
