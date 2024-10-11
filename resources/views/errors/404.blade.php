<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - 404</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('{{ asset('img/404.png') }}') no-repeat center center;
            background-size: cover;
            color: rgba(204, 204, 204, 0.8);
            font-family: Verdana, sans-serif;
            text-align: center;
        }
        .container {
            background-color: rgba(19, 21, 22, 0.9); /* Dark theme */
            padding: 40px;
            border-radius: 10px;
        }
        h1 {
            font-size: 3rem;
            color: #EA580C; /* Orange theme */
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        a {
            padding: 10px 20px;
            background-color: #EA580C;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        a:hover {
            background-color: #ff703d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Oups !</h1>
        <p>La page que vous recherchez est introuvable.</p>
        <a href="{{ url('/') }}">Revenez donc à la page d'accueil !</a>
    </div>
</body>
</html>
