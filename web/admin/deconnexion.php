<?php
// Démarre ou restaure une session
session_start();

include("log.php");

//log
logActivity("", "Deconnexion réussie");

// Détruit toutes les variables de session
$_SESSION = array();

// Supprime le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruit la session
session_destroy();

// Redirige vers la page de connexion ou une autre page appropriée
header("Location: login.php?msg=Vous avez bien été déconnecté.&err=false");
exit();