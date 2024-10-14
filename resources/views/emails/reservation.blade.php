<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isAdmin ? 'Notification Admin - Réservation à la Cabane' : 'Votre Réservation à la Cabane' }}</title>
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
</head>
<body>
    <div class="container">
        <h1>Bonjour {{ $isAdmin ? 'Admin' : $userName }},</h1>

        <div class="status-message">
            <p>
                {{ $isAdmin ? 'Une réservation a été ' : 'Votre demande de réservation a bien été ' }} 
                <strong>
                    @if ($action === 'created')
                        réalisée.
                    @elseif ($action === 'updated')
                        mise à jour sur les <span style="text-decoration: underline">dates et options</span>.
                    @elseif ($action === 'updated_options')
                    mise à jour sur ses <span style="text-decoration: underline">options</span> demandées.
                    @endif
                </strong>
                <br>
                {{ $isAdmin ? '' : 'Nous reviendrons vers vous au plus tôt.' }}
            </p>
        </div>
        
        <div class="reservation-details">
            <p><strong>Détails de la réservation :</strong></p>
            <ul>
                <li><span class="label"><strong>Date d'arrivée :</strong></span> <b>{{ \Carbon\Carbon::parse($reservation->start_date)->translatedFormat('l j F Y') }}</b>, à partir de 14h.</li>
                <li><span class="label"><strong>Date de départ :</strong></span> <b>{{ \Carbon\Carbon::parse($reservation->end_date)->translatedFormat('l j F Y') }}</b>, jusqu'à 12h</li>
                <li><span class="label"><strong>Nombre de nuits :</strong></span> <b>{{ $reservation->nights }}</b></li>
                @if($isAdmin)
                    <li><strong>Nom client :</strong> {{ $userName }}</li>
                    @if($name2)
                        <li><strong>Nom & Prénom seconde personne :</strong> {{ $name2 }}</li>
                    @endif
                    <li><strong>Téléphone :</strong> {{ $phone }}</li>
                    <li><strong>Email :</strong> {{ $email }}</li>
                    <li><strong>ID :</strong> {{ $userId }}</li>
                @endif
                @if($reservation->res_comment)
                    <li><span class="label"><strong>Commentaire :</strong></span> {!! nl2br(e($reservation->res_comment)) !!}</li>
                @endif
                <li><span class="label"><strong>Prix total :</strong></span> <b>{{ number_format($reservation->res_price, $reservation->res_price == (int) $reservation->res_price ? 0 : 2, ',', ' ') }}</b> €</li>
            </ul>
        </div>

        <div class="option-item">
            <p><strong>Options sélectionnées :</strong></p>
            <ul>
                @if($options && count($options))
                    @foreach($options as $option)
                        <li>
                            <span class="label">Option :</span> <span class="green">{{ $option->name }}</span><br>
                            <span class="label" style="white-space: nowrap;">Description :</span> {{ $option->description }}<br>
                            <span class="label">Prix unitaire :</span> {{ $option->price }} € 
                            <span class="label">{{ $option->pivot->by_day ?? false ? 'par nuit réservée' : 'pour le séjour' }}</span><br>
                            soit <span class="bolder">{{ $option->price == 0.00 ? 'Inclu' : ($option->pivot->by_day ?? false ? $option->price * $reservation->nights . ' €' : $option->price . ' €') }}</span>
                        </li>
                    @endforeach
                @else
                    <li>Aucune option sélectionnée.</li>
                @endif
            </ul>
        </div>

        <p>Merci {{ $isAdmin ? 'de gérer cette réservation.' : 'pour votre confiance et à très vite ! 😊' }}</p>

        <div class="footer-message">
            <p>Cabane - Châtel-En-Trièves / Cordéac</p>
        </div>

        <img src="{{ asset('img/hut.png') }}" loading="lazy" alt="Représentation de la Cabane">
    </div>
</body>
</html>
