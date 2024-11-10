<?php

include("../include/utils.php");
include("../log.php");

date_default_timezone_set('Europe/Paris');

if (!isset($_POST["email"]) || !isset($_POST["password"])
    || empty($_POST["email"]) || empty($_POST["password"])) {
    header("location: ../login.php?msg=Veuillez remplire tout les champs.&err=true");
    exit;
}

$db = getDatabase();
$select = $db->prepare("SELECT * FROM utilisateur WHERE email = :email AND administrateur IS NOT NULL");
$select->execute([
    "email" => $_POST["email"]
]);

$resultat = $select->fetch(PDO::FETCH_ASSOC);
var_dump($resultat);

if (!$resultat) {
    logActivity("../", "Tentative de connexion vers l'addresse mail : " . $_POST["email"]);
    header("location: ../login.php?msg=Identifiants incorrects&err=true");
    exit;
}

if (password_verify($_POST["password"], $resultat["mot_de_passe"])) {
    
    $temps_cookie = 14400;
    setcookie("temps", time(), time() + $temps_cookie, "/");

    session_start();
    $_SESSION["admin_email"] = $resultat["email"];
    $_SESSION["admin_id"] = $resultat["id_utilisateur"];
    logActivity("../", "Connexion réussie");
    header("location: ../index.php");
    exit;


} else {
    logActivity("../", "Connexion réussie", $resultat["id_utilisateur"]);
    header("location: ../login.php?msg=Identifiants incorrects&err=true");
    exit;
}