<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/> --}}

        <meta name="description" content="Découvrez la location d'un gîte cabane dans le Trièves. Réservez un séjour unique au cœur de la nature avec jacuzzi et vue panoramique. Réservation en ligne facile pour un séjour relaxant et une expérience unique." />
        <meta name="keywords" content="location gîte, cabane, Trièves, réserver, séjour, nature, jacuzzi, montagne, détente">
        <link rel="canonical" href="https://cabane.leorip.com/">

        <meta property="og:title" content="Location Gîte Cabane dans le Trièves | Séjour Nature avec Jacuzzi">
        <meta property="og:description" content="Réservez une cabane avec jacuzzi et vue panoramique dans le Trièves. Séjour inoubliable dans la nature, parfait pour la détente.">
        <meta property="og:image" content="https://cabane.leorip.com/img/hut.png">
        <meta property="og:url" content="https://cabane.leorip.com/">
        <meta property="og:type" content="website">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Location Gîte Cabane dans le Trièves | Séjour Nature avec Jacuzzi">
        <meta name="twitter:description" content="Réservez une cabane avec jacuzzi et vue panoramique dans le Trièves. Séjour inoubliable dans la nature.">
        <meta name="twitter:image" content="https://cabane.leorip.com/img/hut.png">

        <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="icons/android-chrome-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
        <link rel="mask-icon" href="{{ asset('icons/favicon.ico') }}" color="#5bbad5">
        <link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}">

        <title inertia>Location Gîte Cabane dans le Trièves | Séjour Nature avec Jacuzzi</title>

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Cabane Relaxante",
            "image": "https://cabane.leorip.com/img/hut.png",
            "description": "Location Gîte Cabane dans le Trièves | Réservez dès maintenant. Réservez une cabane avec jacuzzi pour un séjour inoubliable dans la nature.",
            "url": "https://cabane.leorip.com/",
            "telephone": "+33-6-15-16-64-90",
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
        
        <script>
            window.baseUrl = "{{ asset('storage/') }}";
        </script>
    </head>
    <body class="parallax font-sans antialiased">
        @inertia
    </body>
</html>
