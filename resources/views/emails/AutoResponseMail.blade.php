<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Merci pour votre message</title>
    <style>
        .footer-message {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>Merci de nous avoir contacté, {{ $name }} !</h2>
    <p>
        Nous avons bien reçu votre message et reviendrons vers vous dans les plus brefs délais.
    </p>

    <p>
        Si vous avez des questions en attendant, n'hésitez pas à nous contacter à {{ $adminEmail }}.
        <br><br>
        Ou bien directement au 06 XX XX XX XX.
    </p>
    
    <p>Cordialement,</p>
    
    <div class="footer-message">
        <p>Cabane - Châtel-En-Trièves / Cordéac</p>
    </div>

    <img src="{{ asset('hut.png') }}" loading="lazy" alt="Représentation de la Cabane" style="max-width: 750px; height: auto;">
</body>
</html>
