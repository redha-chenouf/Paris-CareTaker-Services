<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion et Inscription</title>
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
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="connexion-tab" data-toggle="tab" href="#connexion" role="tab" aria-controls="connexion" aria-selected="true">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="inscription-tab" data-toggle="tab" href="#inscription" role="tab" aria-controls="inscription" aria-selected="false">Inscription</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Onglet Connexion -->
            <div class="tab-pane fade show active" id="connexion" role="tabpanel" aria-labelledby="connexion-tab">
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
                                <h2 class="text-center">Connexion Bailleur</h2>
                            </div>
                            <div class="card-body">
                                <form action="process/login_bailleur.php" method="post">
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
            <!-- Onglet Inscription -->
            <div class="tab-pane fade" id="inscription" role="tabpanel" aria-labelledby="inscription-tab">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="text-center">Inscription Bailleur</h2>
                            </div>
                            <div class="card-body">
                                <form action="process/inscription_bailleur.php" method="post">
                                    <!-- Ajoutez ici les champs supplémentaires pour l'inscription -->
                                    <div class="form-group">
                                        <label for="nom">Nom:</label>
                                        <input type="text" class="form-control" id="nom" name="nom" >
                                    </div>
                                    <div class="form-group">
                                        <label for="prenom">Prénom:</label>
                                        <input type="text" class="form-control" id="prenom" name="prenom" >
                                    </div>
                                    <!-- Ajoutez d'autres champs ici -->
                                    <button type="submit" class="btn btn-primary btn-block">Inscription</button>
                                </form>
                            </div>
                        </div>
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
