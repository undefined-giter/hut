<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression de compte et annulation de réservations</title>
    
    <style>
        {{ file_get_contents(public_path('css/mailCSS.css')) }}
    </style>
</head>
<body>
    <div class="container">
        <h2>Compte et réservations supprimés</h2>

        <div class="contact-info">
            @if($isAdmin)
                <p>Le compte de <strong>{{ $user->name ?? $user->email }}</strong> a été supprimé, et toutes ses réservations futures ont été annulées.</p>
            @else
                <p>Nous vous confirmons que votre compte, <strong>{{ $user->name }}</strong>, a été supprimé, et vos réservations futures ont été annulées.</p>
            @endif

            <div class="reservation-details">
                @if($reservations && $reservations->count() > 1)
                    <p><strong>Détails des réservations annulées :</strong></p>
                @else
                    <p><strong>Détails de la réservation annulée :</strong></p>
                @endif
                @if($reservations && $reservations->isNotEmpty())
                    <table style="width: 90%; margin: 0 auto; text-align: center;">
                        <thead>
                            <tr>
                                <th>Date&nbsp;d'entrée</th>
                                <th>Date&nbsp;de&nbsp;sortie</th>
                                <th>Nb&nbsp;de&nbsp;nuits</th>
                                <th>Commentaire</th>
                                @if($isAdmin)
                                    <th>Prix</th>
                                    <th>Création</th>
                                    <th>MAJ</th>
                                    <th>Res ID</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr style="text-align:center;">
                                    <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->nights }}</td>
                                    <td>{{ $reservation->res_comment ?? '-' }}</td>
                                    @if($isAdmin)
                                        <td>{{ number_format($reservation->res_price, $reservation->res_price == (int) $reservation->res_price ? 0 : 2, ',', ' ') }}<span style="font-size: 0.6em;">&nbsp;€</span></td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->updated_at)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y') }}</td>
                                        <td>{{ $reservation->id }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Il n'y avait pas de réservation future annulée.</p>
                @endif
            </div>
        </div>

        @if(!$isAdmin)
            <p>N'hésitez pas à nous contacter pour toute question.</p>

            <p>Bien cordialement,</p>
        @endif
        
        @include('emails.partials.footer')
    </div>
</body>
</html>
