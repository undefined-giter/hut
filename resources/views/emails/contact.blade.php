<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabane - Nouveau message de {{ $name }}</title>

    <style>
        {{ file_get_contents(public_path('css/mailCSS.css')) }}
    </style>
</head>
<body>
    <div class="container">
        <h1>Nouveau message de {{ $name }}</h1>

        <div class="contact-info">
            <p><strong>Email :</strong> <b>{{ $email }}</b></p>
            @if (!empty($phone))
                @php
                    $formattedPhone = preg_replace('/\B(?=(..)+(?!\d))/', ' ', strrev($phone));
                    $formattedPhone = strrev($formattedPhone);
                @endphp
                <p><strong>Téléphone :</strong> <b>{{ $formattedPhone }}</b></p>
            @endif
        </div>

        <div class="message-content">
            <p><strong>Message :</strong> {!! nl2br(e($messageContent)) !!}</p>
        </div>

        @include('emails.partials.footer')
    </div>
</body>
</html>
