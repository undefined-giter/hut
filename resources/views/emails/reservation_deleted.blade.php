<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isAdmin ? 'Notification Admin - Réservation Annulée' : 'Votre Réservation a été Annulée' }}</title>
    <style>
        body {
            background-color: #141a23;
            color: #ffffff;
            font-family: Verdana, sans-serif;
        }
        h1, p, strong, label { color: #EA580C; }
        li {
            color: #cccccc;
            line-height: 1.6;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li { margin-bottom: 10px; }
        .container {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            background-color: #1f2937;
            padding: 20px;
            border-radius: 8px;
        }
        .option-item, .reservation-details, .status-message {
            background-color: #0d1117;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .green {
            color: green;
            font-size: 1.04rem;
        }
        b { font-size: 1.04rem; }
        .bolder { font-weight: 600; }
        .footer-message {
            color: gray;
            margin-top: 30px;
            text-align: center;
        }
        img {
            max-width: 300px;
            height: auto;
            border-radius: 50%;
            display: block;
            margin: 20px auto;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var phoneElement = document.getElementById('phone');
            var phone = phoneElement.innerText;
            if (phone && phone.length > 0) {
                var formattedPhone = phone.replace(/(\d{2})(?=\d)/g, "$1 ");
                phoneElement.innerText = formattedPhone;
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Bonjour {{ $isAdmin ? 'Admin' : $userName }},</h1>

        <div class="status-message">
            <p>
                {{ $isAdmin ? 'Une réservation a été ' : 'Votre réservation a été ' }} 
                <strong>annulée</strong>.
            </p>
        </div>
        
        <div class="reservation-details">
            <p><strong>Détails de la réservation annulée :</strong></p>
            <ul>
                <li><span class="label"><strong>Date d'arrivée :</strong></span> <b>{{ \Carbon\Carbon::parse($reservation->start_date)->translatedFormat('l j F Y') }}</b>.</li>
                <li><span class="label"><strong>Date de départ :</strong></span> <b>{{ \Carbon\Carbon::parse($reservation->end_date)->translatedFormat('l j F Y') }}</b>.</li>
                <li><span class="label"><strong>Nombre de nuits :</strong></span> <b>{{ $reservation->nights }}</b></li>
                @if($isAdmin)
                    @if($userName)
                        <li><strong>Nom client :</strong> <b>{{ $userName }}</b></li>
                    @endif
                    @if($name2)
                        <li><strong>Seconde personne :</strong> <b>{{ $name2 }}</b></li>
                    @endif
                    <li><strong>Email :</strong> <b>{{ $email }}</b></li>
                    @if($phone)
                        <li><strong>Téléphone :</strong> <b id="phone">{{ $phone }}</b></li>
                    @endif
                    <small><li><strong>user ID / res ID :</strong> {{ $userId }} / {{ $reservation->id }}</li></small>
                @endif
            </ul>
        </div>

        <p>{{ $isAdmin ? 'Sniff sniff.' : 'Nous espérons vous revoir à l\'avenir ! 🙂' }}</p>

        @include('emails.partials.footer')

        <img src="{{ asset('img/hut.png') }}" loading="lazy" alt="Représentation de la Cabane">
    </div>
</body>
</html>
