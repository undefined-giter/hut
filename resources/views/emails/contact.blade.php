<!DOCTYPE html>
<html>
<head>
    <title>Cabane - Nouveau message de {{ $name }}</title>
</head>
<body>
    <h2>Nouveau message de {{ $name }}</h2>
    @if (!empty($email))<p><strong>Email :</strong> {{ $email }}</p>@endif
    @if (!empty($phone))
        @php
            $formattedPhone = preg_replace('/\B(?=(..)+(?!\d))/', ' ', strrev($phone));
            $formattedPhone = strrev($formattedPhone);
        @endphp
        <p><strong>Téléphone :</strong> {{ $formattedPhone }}</p>
    @endif
    <p><strong>Message :</strong></p>
    <p>{!! nl2br(e($messageContent)) !!}</p>
</body>
</html>
