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
            line-height: 1.6;
            padding: 20px;
        }
        h1, p, strong, .label, .footer-message {
            @apply text-orangeTheme
        }
        li {
            color: #cccccc;
            margin-bottom: 10px;
        }
        .message-content {
            background-color: #1f2937;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .contact-info {
            background-color: #0d1117;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .footer-message {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h1>Nouveau message de {{ $name }}</h1>

    <div class="contact-info">
        @if (!empty($email))
            <p><strong>Email :</strong> <b>{{ $email }}</b></p>
        @endif
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
        <p>Cabane - Châtel-En-Trièves / Cordéac</p>
    </div>

    <img src="{{ asset('img/hut.png') }}" loading="lazy" alt="Représentation de la Cabane" style="max-width: 750px; height: auto;">
</body>
</html>
