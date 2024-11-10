<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <?php

            if (isset($_GET["msg"]) && $_GET["err"] == 'true'){
                echo '
                <div class="alert alert-danger" role="alert">
                    '. $_GET["msg"] .'
                </div>
                ';
            } elseif (isset($_GET["msg"]) && $_GET["err"] == 'false') {
                echo '
                <div class="alert alert-success" role="alert">
                    '. $_GET["msg"] .'
                </div>
                ';
            }

            ?>
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Connexion Administrateur</h2>
                    </div>
                    <div class="card-body">
                        <form action="process/login.php" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" >
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe:</label>
                                <input type="password" class="form-control" id="password" name="password" >
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Connexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
