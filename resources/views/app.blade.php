<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('icons/favicon.ico') }}" type="image/x-icon">

        <meta name="description" content="Profitez d'un séjour unique dans une cabane relaxante avec jacuzzi, nichée au cœur du Trièves avec vue panoramique sur les montagnes environnantes.">
        <meta name="keywords" content="cabane, gîte, Trièves, cabane Trièves, gîte Trièves, jacuzzi, location, location cabane, hébergement, cabane en bois, vue panoramique, réservation, séjour nature, montagne, détente, relaxant, vacances Trièves">
        @if (request()->is('/'))
            <link rel="canonical" href="https://cabane.leorip.com" />
        @endif
        <meta name="robots" content="index, follow">

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="Cabane avec Jacuzzi - Trièves Location" />
        <meta property="og:description" content="Profitez d'un séjour unique dans une cabane relaxante avec jacuzzi, nichée au cœur du Trièves avec sa vue panoramique sur les montagnes environnantes." />
        <meta property="og:image" content="https://cabane.leorip.com/img/hut.png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Image d'une cabane avec jacuzzi dans le Trièves pour séjour en nature">
        <meta property="og:url" content="https://cabane.leorip.com">
        <meta property="og:type" content="website">

        <meta name="theme-color" content="#141414">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Cabane avec Jacuzzi - Trièves Location">
        <meta name="twitter:description" content="Profitez d'un séjour unique dans une cabane relaxante avec jacuzzi, nichée au cœur du Trièves avec sa vue panoramique sur les montagnes environnantes.">
        <meta name="twitter:image" content="https://cabane.leorip.com/img/hut.png">

        <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/android-chrome-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
        <link rel="mask-icon" href="{{ asset('icons/favicon.ico') }}" color="#ad5205">

        <link rel="preload" as="image" href="{{ asset('img/hut.png') }}" type="image/png">
        
        <title inertia>Cabane avec Jacuzzi - Trièves Location</title>

        <meta property="og:site_name" content="Hébergement Cabane Trièves">

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Cabane Jacuzzi Trièves",
            "additionalType": "https://schema.org/LodgingBusiness",
            "image": "https://cabane.leorip.com/img/hut.png",
            "description": "Profitez d'un séjour unique dans une cabane relaxante avec jacuzzi, nichée au cœur du Trièves avec sa vue panoramique sur les montagnes environnantes.",
            "url": "https://cabane.leorip.com",
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
            "sameAs": [
                "https://www.facebook.com/TODO",
                "https://www.instagram.com/TODO"
            ],
            "openingHoursSpecification": [
                {
                    "@type": "OpeningHoursSpecification",
                    "dayOfWeek": [
                        "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
                    ],
                    "opens": "14:00",
                    "closes": "12:00"
                }
            ],
            "amenityFeature": [
                {"@type": "LocationFeatureSpecification", "name": "Jacuzzi", "value": "true"},
                {"@type": "LocationFeatureSpecification", "name": "Wi-Fi", "value": "true"},
                {"@type": "LocationFeatureSpecification", "name": "Parking gratuit", "value": "true"}
            ],
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.8",
                "reviewCount": "56"
            },
            "review": [
                {
                    "@type": "Review",
                    "author": {
                        "@type": "Person",
                        "name": "Mickaël"
                    },
                    "datePublished": "2024-10-10",
                    "reviewBody": "Séjour fantastique dans une cabane avec vue panoramique. Jacuzzi au top!",
                    "reviewRating": {
                        "@type": "Rating",
                        "ratingValue": "5"
                    }
                }
            ]
        }
        </script>  

        <script>window.baseUrl = "{{ asset('storage/') }}";</script>

        @if (request()->routeIs('payment.show') || request()->routeIs('payment.process'))
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap">
            <script src="https://js.stripe.com/v3/"></script>
        @endif
    </head>
    <body class="bg_img">
        @inertia
    </body>
</html>
