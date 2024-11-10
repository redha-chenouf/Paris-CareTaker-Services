<?php
function generateHeader($path) {
    echo '
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container justify-content-center">
                <a class="navbar-brand" href="'.$path.'.">PCS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCompte" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Compte
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCompte">
                                <li><a class="dropdown-item" href="'. $path .'bailleurs.php">Bailleurs</a></li>
                                <li><a class="dropdown-item" href="'. $path .'voyageurs.php">Voyageurs</a></li>
                                <li><a class="dropdown-item" href="'. $path .'prestataires.php">Prestataires</a></li>
                                <li><a class="dropdown-item" href="'. $path .'administrateur.php">Administrateur</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProduit" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Produit
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownProduit">
                                <li><a class="dropdown-item" href="'. $path .'biens.php">Biens</a></li>
                                <li><a class="dropdown-item" href="'. $path .'prestations.php">Prestations</a></li>
                                <li><a class="dropdown-item" href="'. $path .'prestations.php">Reservations</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Paiement</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profil
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownProfil">
                                <li><a class="dropdown-item" href="'. $path .'parametre.php">Paramètres</a></li>
                                <li><a class="dropdown-item" href="'. $path .'show_log.php">Logs</a></li>
                                <li><a class="dropdown-item text-danger" href="'. $path .'deconnexion.php">Déconnexion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    ';
}
?>
