<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre message</title>
    <style>
        body {
            background-color: #141a23;
            color: #ffffff;
            font-family: Verdana, sans-serif;
        }
        h2, p, strong {
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
        <h2>Merci de nous avoir contacté {{ $name }},</h2>

        <div class="contact-info">
            <p>Nous avons bien reçu votre message et reviendrons vers vous dans les plus brefs délais.</p>
        </div>

        <p>
            Si vous avez des questions en attendant, n'hésitez pas à nous contacter directement.
        </p>
        
        <p>Cordialement,</p>
        
        @include('emails.partials.footer')

        <img src="{{ asset('img/hut.png') }}" loading="lazy" alt="Location gîte cabane dans le Trièves">
    </div>
</body>
</html>
