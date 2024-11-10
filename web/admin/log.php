<?php
// Fonction pour obtenir l'adresse IP du client
function getIPAddress() {
    // Vérifier si une IP est passée par un proxy
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // HTTP_X_FORWARDED_FOR peut contenir une liste d'IP (proxy chain)
        $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ip_list[0]);
    } else {
        // Sinon, prendre l'IP de l'utilisateur direct
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Fonction pour enregistrer les journaux d'activité
function logActivity($path, $action, $user_id = null) {
    // Définir le fuseau horaire
    date_default_timezone_set('Europe/Paris');
    $timestamp = date("Y/m/d H:i:s");

    if (isset($user_id) && !empty($user_id)) {
        $user = '_'.$user_id;
        $id = $user_id;
    } elseif (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
        $user = '_'.$_SESSION['admin_id'];
        $id = $_SESSION["admin_id"];
    } else {
        $user = '';
        $id = 'anonymous'; // Pour éviter les erreurs, on peut définir un ID par défaut
    }

    // Obtenir l'adresse IP du client
    $ip_address = getIPAddress();

    // Créer le log
    $log = "$ip_address - $timestamp - $id - $action\n";

    // Enregistrer le log dans le fichier
    file_put_contents($path .'logs/activity_log'. $user .'.txt', $log, FILE_APPEND);
}