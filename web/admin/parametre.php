<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page parametre.php");

$db = getDatabase();

// Traitement du changement d'email
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_email"]) && isset($_POST["confirm_email"])) {
    // Validation de l'email (vous pouvez ajouter plus de validation si nécessaire)
    $new_email = $_POST["new_email"];
    $confirm_email = $_POST["confirm_email"];
    
    // Vérification si les deux adresses e-mail sont identiques
    if ($new_email === $confirm_email) {
        
        $check = $db->prepare("SELECT COUNT(*) AS count FROM administrateur WHERE email = :email");
        $check->execute([
            'email' => $new_email
        ]);
    
        $get = $check->fetch();
        
        if ($get["count"] > 0) {
    
            logActivity("", "Erreur changement mail $new_email est déjà pris.");
            header("Location: parametre.php?msg=Le mail existe déjà, vous ne pouvez pas l'utiliser.&err=true");
            exit; // Assurez-vous de terminer l'exécution du script après la redirection
    
        } else {
            $old_email = $_SESSION["admin_email"];
            $update = $db->prepare("UPDATE administrateur SET email = :newEmail WHERE email = :oldEmail");
            $check_update = $update->execute([
                'newEmail' => $new_email,
                'oldEmail' => $old_email
            ]);
    
            if ($check_update) {

                $_SESSION["admin_email"] = $new_email;

                logActivity("", "Changement de mail réussi $old_email par $new_email");
                header("Location: parametre.php?msg=Changement réussi.&err=false");
                exit;
            } else {
                logActivity("", "Erreur lors du changement de mail $old_email par $new_email");
                header("Location: parametre.php?msg=Une erreur est survenue réessayez plus tard.&err=true");
                exit;
            }
        }
    } else {
        // Les adresses e-mail ne correspondent pas, afficher un message d'erreur
        $email_error = "Les adresses e-mail ne correspondent pas.";
    }
}

// Traitement du changement de mot de passe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
    // Validation du nouveau mot de passe (vous pouvez ajouter plus de validation si nécessaire)
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Vérification si les deux mots de passe sont identiques
    if ($new_password === $confirm_password) {

        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $setNewPassword = $db->prepare("UPDATE administrateur SET password = :newPassword WHERE id_administrateur = :id");
        $setNewPassword->execute([
            'id' => $_SESSION["admin_id"],
            'newPassword' => $hash
        ]);

        // Enregistrement du changement de mot de passe dans les journaux d'activité
        logActivity("", "Changement de mot de passe réussi");
        header("location: parametre.php?msg=Changement de mot de passe réussi.&err=false");
    } else {
        // Les mots de passe ne correspondent pas, afficher un message d'erreur
        header("location: parametre.php?msg=Erreur lors du changement du mot de passe les 2 mots de passe ne correspondent pas.&err=true");
        logActivity("", "Changement de mot de passe échoué, les 2 mots de passe ne correspondent pas");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres</title>
    <!-- Intégration de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">

        <?php

        if (isset($_GET["msg"]) && $_GET["err"] == 'true'){
            echo '
            <div class="alert alert-danger mt-3" role="alert">
                '. $_GET["msg"] .'
            </div>
            ';
        } elseif (isset($_GET["msg"]) && $_GET["err"] == 'false') {
            echo '
            <div class="alert alert-success mt-3" role="alert">
                '. $_GET["msg"] .'
            </div>
            ';
        }

        ?>

        <h1 class="mt-1">Paramètres</h1>

        <!-- Formulaire de changement d'email -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
            <div class="form-group">
                <label for="new_email">Nouvel email :</label>
                <input type="email" id="new_email" name="new_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_email">Confirmer nouvel email :</label>
                <input type="email" id="confirm_email" name="confirm_email" class="form-control" required>
                <?php if(isset($email_error)) echo "<p class='text-danger'>$email_error</p>"; ?>
            </div>
            <button type="submit" class="btn btn-primary">Changer l'adresse email</button>
        </form>

        <!-- Formulaire de changement de mot de passe -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
            <div class="form-group">
                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer nouveau mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                <?php if(isset($password_error)) echo "<p class='text-danger'>$password_error</p>"; ?>
            </div>
            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
