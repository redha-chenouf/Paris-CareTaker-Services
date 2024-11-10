<?php


include("database.php");

function checkSessionElseLogin($path): void
{

    date_default_timezone_set('Europe/Paris');

    if (!session_start()){
        session_start();
    }

    if (!isset($_SESSION['admin_email']) || !isset($_SESSION['admin_id'])){
        header("location: ". $path ."login.php?msg=Vous devez vous connecter.&err=true");
        exit;
    }

    $temps_cookie = 14400;

    if ((isset($_COOKIE['temps']) && ($_COOKIE['temps'] + $temps_cookie < time() + 7200)) || !isset($_COOKIE['temps'])) {
        header("location: " . $path . "login.php?msg=Votre session a expiré. Veuillez vous reconnecter.&err=true");
        exit;
    }

}

function displayError($msg, $err) {
    if (isset($msg) && $err == 'true'){
        echo '
        <div class="alert alert-danger" role="alert">
            '. $msg .'
        </div>
        ';
    } elseif (isset($msg) && $err == 'false') {
        echo '
        <div class="alert alert-success" role="alert">
            '. $msg .'
        </div>
        ';
    } else {
        echo '';
    }
}

function displayIcon($path){
    echo '<link rel="icon" href="'. $path .'assets/logo.png" type="image/png">';
}