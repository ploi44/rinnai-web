<!DOCTYPE html>
<html lang="en">
<head>
    {{ $head }}
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
