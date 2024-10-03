<!DOCTYPE html>
<html>
<head>
    <title>Cabane - Nouveau message de contact</title>
</head>
<body>
    <h1>Nouveau message de contact</h1>
    <p><strong>Nom :</strong> {{ $name }}</p>
    <p><strong>Email :</strong> {{ $email }}</p>
    <p><strong>Message :</strong></p>
    <p>{!! nl2br(e($messageContent)) !!}</p>
</body>
</html>
