<?php

function hasherMotDePasse($motDePasse) {
    $hash = password_hash($motDePasse, PASSWORD_BCRYPT);
    return $hash;
}

// Exemple d'utilisation
$motDePasse = "esgi";
$hashMotDePasse = hasherMotDePasse($motDePasse);
echo "Mot de passe : " . $motDePasse . "<br>";
echo "Mot de passe haché : " . $hashMotDePasse;