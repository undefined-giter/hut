<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de votre adresse email</title>

    <style>
        {{ file_get_contents(public_path('css/mailCSS.css')) }}
    </style>
</head>
<body>
    <div class="container">
        <h2>Merci de vérifier votre adresse email,</h2>

        <div class="contact-info" style="text-align: center; align-items: center;">
            <p>Suite à votre inscription sur sur notre site Cabane, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous.</p>
            <a href="{{ $verificationUrl }}" class="button" style="
                color: #ccc; 
                text-decoration: none; 
                padding: 10px 20px; 
                background-color: #EA580C; 
                border: 3px solid #ffbd79; 
                border-radius: 5px; 
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ombre externe pour profondeur */
                display: inline-block; 
                position: relative; 
                margin-top: -16px;
            ">
                <b>Vérifier mon adresse email</b>
            </a>
        </div>

        <p>
            Si le lien ne fonctionne pas, copiez et collez l'URL suivante dans votre navigateur :
            <br>
            <span style="color: #EA580C">{{ $verificationUrl }}</span>
        </p>
        
        <p>Si vous avez des questions en attendant, n'hésitez pas à nous contacter directement.</p>
        
        <p>Cordialement,</p>
        
        @include('emails.partials.footer')
    </div>
</body>
</html>
