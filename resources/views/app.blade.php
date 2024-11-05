<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('icons/favicon.ico') }}" type="image/x-icon">

        <meta name="description" content="Découvrez la location d'une cabane relaxante avec jacuzzi dans le Trièves. Un séjour unique avec vue panoramique.">
        <meta name="keywords" content="location gîte, cabane, Trièves, réservation, séjour nature, jacuzzi, montagne, détente, hébergement, cabane en bois, vue panoramique, vacances Trièves">
        <link rel="canonical" href="https://cabane.leorip.com/">
        <meta name="robots" content="index, follow">

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="Location Cabane Relaxante avec Jacuzzi - Trièves" />
        <meta property="og:description" content="Profitez d'un séjour unique dans une cabane relaxante avec jacuzzi, nichée au cœur du Trièves avec vue sur les montagnes." />
        <meta property="og:image" content="https://cabane.leorip.com/img/hut.png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Image d'une cabane relaxante avec jacuzzi dans le Trièves pour séjour en nature">
        <meta property="og:url" content="https://cabane.leorip.com/">
        <meta property="og:type" content="website">

        <meta name="theme-color" content="#141414">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Location Cabane Relaxante avec Jacuzzi - Trièves">
        <meta name="twitter:description" content="Découvrez un hébergement unique avec jacuzzi et vue panoramique dans le Trièves. Réservez votre escapade en nature dès maintenant.">
        <meta name="twitter:image" content="https://cabane.leorip.com/img/hut.png">

        <link rel="manifest" href="{{ asset('/site.webmanifest') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/android-chrome-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
        <link rel="mask-icon" href="{{ asset('icons/favicon.ico') }}" color="#5bbad5">

        <title>Location Cabane Relaxante avec Jacuzzi - Séjour Nature dans le Trièves</title>

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "Cabane Relaxante",
            "additionalType": "https://schema.org/LodgingBusiness",
            "image": "https://cabane.leorip.com/img/hut.png",
            "description": "Réservez une cabane relaxante avec jacuzzi et vue panoramique dans le Trièves pour un séjour unique.",
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
            "sameAs": [
                "https://www.facebook.com/tonprofil",
                "https://www.instagram.com/tonprofil"
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
                "reviewCount": "27"
            },
            "review": [
                {
                    "@type": "Review",
                    "author": "Mickaël",
                    "datePublished": "2024-10-10",
                    "reviewBody": "Séjour fantastique dans une cabane avec vue panoramique. Jacuzzi au top!",
                    "reviewRating": {"@type": "Rating", "ratingValue": "5"}
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
