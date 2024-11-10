<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur 404 - PCS</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        .container {
            text-align: center;
            padding: 40px;
            border: 2px solid #ddd;
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 72px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .home-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #3498db;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .home-link:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="/assets/logo.png" alt="Logo PCS" class="logo">
        <div class="error-code">404</div>
        <div class="error-message">Page non trouvée</div>
        <a href="https://pariscs.fr" class="home-link">Retour à l'accueil</a>
    </div>
</body>
</html>
