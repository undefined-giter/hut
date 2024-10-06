<!DOCTYPE html>
<html>
<head>
    <title>Cabane - Nouveau message de {{ $name }}</title>
</head>
<body>
    <h1>Nouveau message de contact</h1>
    <p><strong>Nom :</strong> {{ $name }}</p>
    <p><strong>Nom :</strong> {{ $name }}</p>
    @if (!empty($email))<p><strong>Email :</strong> {{ $email }}</p>@endif
    @if (!empty($phone))<p><strong>Téléphone :</strong> {{ $phone }}</p>@endif
    <p><strong>Message :</strong></p>
    <p>{!! nl2br(e($messageContent)) !!}</p>
</body>
</html>
