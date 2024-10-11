<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/> --}}

        <meta name="description" content="Découvrez une expérience unique avec une vue à couper le souffle dans notre cabane munie d'un jacuzzi, venez profiter d'un séjour détente en location cabane. Consultez la galerie d'images, réservez facilement en ligne et profitez d'un séjour relaxant." />

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('icons/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('icons/favicon.ico') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}">

        <title inertia>{{ config('app.name', 'Bienvenue') }} | Cabane</title>

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Cabane Relaxante",
            "image": "https://cabane.leorip.com/img/hut.png",
            "description": "Réservez une cabane avec jacuzzi pour un séjour inoubliable dans la nature.",
            "url": "https://cabane.leorip.com/reserver",
            "telephone": "+33-6-XX-XX-XX-XX",
            "address": {
            "@type": "PostalAddress",
            "streetAddress": "972 Chenalbonne",
            "addressLocality": "Montagne",
            "postalCode": "38710",
            "addressCountry": "FR"
            },
            "geo": {
            "@type": "GeoCoordinates",
            "latitude": "44.832174",
            "longitude": "5.830722"
            },
            "priceRange": "€€",
            "openingHours": "Mo-Su 14:00-12:00",
            "amenityFeature": [
            {
                "@type": "LocationFeatureSpecification",
                "name": "Jacuzzi",
                "value": "true"
            },
            {
                "@type": "LocationFeatureSpecification",
                "name": "Wi-Fi",
                "value": "true"
            },
            {
                "@type": "LocationFeatureSpecification",
                "name": "Parking gratuit",
                "value": "true"
            }
            ]
        }
        </script>            
    </head>
    <body class="parallax font-sans antialiased">
        <script>
           baseUrl = "{{ rtrim(asset('storage/'), '/') }}/";
        </script>

        @inertia
    </body>
</html>
