<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de Réservation</title>
    <style>
        body {
            background-color: #141a23;
            color: #ffffff;
            font-family: Verdana, sans-serif;
        }
        h1, p {color: #EA580C; }
        li {
            color: #cccccc;
            line-height: 1.6;
        }
        strong {color: #EA580C;}
        ul {
            list-style-type: none;
            padding: 0;
        }
        li { margin-bottom: 10px; }
        .reservation-details {
            background-color: #1f2937;
            width: 750px,
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .option-item {
            background-color: #0d1117;
            width: 750px,
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .label { color: #EA580C; }
        .green{
            color: green;
            font-size : 1.04rem;
        }
        b{font-size : 1.04rem;}
        .bolder{font-weight: 600}
        .footer-message {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h1>Bonjour,</h1>
    
    <p>Votre demande de réservation à bien étée <strong>{{ $action === 'created' ? 'réalisée' : 'mise à jour' }}</strong>.<br>
    Nous reviendrons vers vous au plus tôt.</p>
    
    <div class="reservation-details">
        <p><strong>Détails de la réservation :</strong></p>
        <ul>
            <li><span class="label"><strong>Date d'arrivée :</strong></span> <b>{{ \Carbon\Carbon::parse($reservation->start_date)->translatedFormat('l j F Y') }}</b>, à partir de 14h.</li>
            <li><span class="label"><strong>Date de départ :</strong></span> <b>{{ \Carbon\Carbon::parse($reservation->end_date)->translatedFormat('l j F Y') }}</b>, jusqu'à 12h</li>
            <li><span class="label"><strong>Nombre de nuits :</strong></span> <b>{{ $reservation->nights }}</b></li>
            @if($isAdmin)
                <li><strong>Réservation ID :</strong> {{ $reservation->id }}</li>
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
                        <span class="label">Description :</span> {{ $option->description }}<br>
                        <span class="label">Prix unitaire :</span> {{ $option->price }} € 
                        <span class="label">{{ $option->pivot->by_day ?? false ? 'par nuit réservée' : 'pour le séjour' }}</span><br>
                        soit <span class="bolder">{{ $option->price == 0.00 ? 'offert' : ($option->pivot->by_day ?? false ? $option->price * $reservation->nights . ' €' : $option->price . ' €') }}</span>
                    </li>
                @endforeach
            @else
                <li>Aucune option sélectionnée.</li>
            @endif
        </ul>
    </div>
    
    <p>Merci pour votre confiance et à très vite ! 😊</p>

    <div class="footer-message">
        <p>Cabane - Châtel-En-Trièves / Cordéac</p>
    </div>

    <img src="{{ asset('hut.png') }}" loading="lazy" alt="Représentation de la Cabane" style="max-width: 750px; height: auto;">
</body>
</html>
