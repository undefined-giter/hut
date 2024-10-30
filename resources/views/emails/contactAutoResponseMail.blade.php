<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre message</title>
    
    <style>
        {{ file_get_contents(public_path('css/mailCSS.css')) }}
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
    </div>
</body>
</html>
