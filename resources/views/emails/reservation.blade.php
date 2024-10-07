<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de Réservation</title>
    <style>
        body {
            background-color: #141a23;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }
        h1 {color: #EA580C; }
        p, li {
            color: #ffffff;
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
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .option-item {
            background-color: #0d1117;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Bonjour,</h1>
    
    <p>Votre réservation a bien été <strong>{{ $action === 'created' ? 'créée' : 'mise à jour' }}</strong>.</p>
    
    <div class="reservation-details">
        <p><strong>Détails de la réservation :</strong></p>
        <ul>
            <li><strong>ID :</strong> {{ $reservation->id }}</li>
            <li><strong>Date d'arrivée :</strong> {{ $reservation->start_date }}</li>
            <li><strong>Date de départ :</strong> {{ $reservation->end_date }}</li>
            <li><strong>Nombre de nuits :</strong> {{ $reservation->nights }}</li>
            <li><strong>Commentaire :</strong> {{ $reservation->res_comment ?? 'Aucun commentaire' }}</li>
            <li><strong>Prix total :</strong> {{ $reservation->res_price }} €</li>
        </ul>
    </div>

    <p><strong>Options sélectionnées :</strong></p>
    <ul>
        @if($reservation->options && $reservation->options->count())
            @foreach($reservation->options as $option)
                <li class="option-item">
                    <strong>Option :</strong> {{ $option->name }}<br>
                    <strong>Description :</strong> {{ $option->description }}<br>
                    <strong>Prix unitaire :</strong> {{ $option->price }} €<br>
                    {{ $option->pivot->by_day ? 'Option par nuit réservée' : 'Option pour le séjour' }}<br>
                    soit <strong>{{ $option->pivot->by_day ? $option->price * $reservation->nights : $option->price }} €</strong>
                </li>
            @endforeach
        @else
            <li>Aucune option demandée</li>
        @endif
    </ul>
    
    <p>Merci pour votre confiance et à très vite !</p>
</body>
</html>
