<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabane - Nouveau message de {{ $name }}</title>
    <style>
        body {
            background-color: #141a23;
            color: #ffffff;
            font-family: Verdana, sans-serif;
        }
        h1, p, strong {
            color: #EA580C;
        }
        .container {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            background-color: #1f2937;
            padding: 20px;
            border-radius: 8px;
        }
        .contact-info {
            background-color: #0d1117;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .message-content {
            background-color: #0d1117;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
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

        <div class="footer-message">
            <p>
                @if ( $adminPhone )
                    {{ $adminPhone }}<br>
                @endif
                Cabane - Châtel-En-Trièves / Cordéac
            </p>
        </div>

        <img src="{{ asset('img/hut.png') }}" loading="lazy" alt="Représentation de la Cabane">
    </div>
</body>
</html>
