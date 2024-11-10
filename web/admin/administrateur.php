<?php
include("include/utils.php");
checkSessionElseLogin("");

include("include/header.php");
generateHeader("");

include("log.php");
logActivity("", "page administrateur.php");

// Récupérer l'ID de l'utilisateur en cours
$currentUserId = $_SESSION["admin_id"];

// Récupérer tous les administrateurs
$db = getDatabase();
$administrateurs = $db->query("SELECT * FROM utilisateur WHERE administrateur IS NOT NULL")->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur en cours est dans la liste des administrateurs
$isAdmin = false;
foreach ($administrateurs as $admin) {
    if ($admin['id_utilisateur'] === $currentUserId) {
        $isAdmin = true;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateurs</title>
    <!-- Intégration de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-3">

        <?php
        if (isset($_GET["msg"]) && isset($_GET["err"])) {
            displayError($_GET["msg"], $_GET["err"]);
        }
        ?>
        <h1>Administrateurs</h1>
        
        <!-- Bouton pour ouvrir le modal de création d'utilisateur -->
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#creerUtilisateurModal">Créer un utilisateur</button>
        
        <!-- Tableau des administrateurs -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Depuis le</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($administrateurs as $admin): ?>
                    <tr>
                        <td><?php echo $admin['id_utilisateur']; ?></td>
                        <td><?php echo $admin['administrateur']; ?></td>
                        <td><?php echo $admin['prenom']; ?></td>
                        <td><?php echo $admin['email']; ?></td>
                        <td>
                            <!-- Boutons d'action -->
                            <?php if ($admin['id_utilisateur'] !== $_SESSION["admin_id"]): ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsAdminModal_<?php echo $admin['id_utilisateur']; ?>">
                                    <img src="assets/detail.png" alt="Détail">
                                </button>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editAdminModal_<?php echo $admin['id_utilisateur']; ?>">
                                    <img src="assets/edit.png" alt="Modifier">
                                </button>
                                <button type="button" class="btn btn-danger deleteUserBtn"
                                        data-user-id="<?php echo $admin['id_utilisateur']; ?>"
                                        data-username="<?php echo $admin['prenom']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal_<?php echo $admin['id_utilisateur']; ?>">
                                        <img src="assets/delete.png" alt="Supprimer">
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-primary" disabled>
                                    <img src="assets/detail.png" alt="Détail">
                                </button>
                                <button type="button" class="btn btn-warning" disabled>
                                    <img src="assets/edit.png" alt="Modifier">
                                </button>
                                <button type="button" class="btn btn-danger" disabled>
                                    <img src="assets/delete.png" alt="Supprimer">
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Le modal de création d'utilisateur -->
    <div class="modal fade" id="creerUtilisateurModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Créer un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenu du modal -->
                    <form id="creerUtilisateurForm" action="process/newAdmin.php" method="post">
                        <div class="mb-3">
                            <label for="nomUtilisateur" class="form-label">Nom :</label>
                            <input type="text" class="form-control" id="nomUtilisateur" name="nomUtilisateur">
                        </div>
                        <div class="mb-3">
                            <label for="prenomUtilisateur" class="form-label">Prenom :</label>
                            <input type="text" class="form-control" id="prenomUtilisateur" name="prenomUtilisateur">
                        </div>
                        <div class="mb-3">
                            <label for="emailUtilisateur" class="form-label">Adresse email :</label>
                            <input type="email" class="form-control" id="emailUtilisateur" name="emailUtilisateur">
                        </div>
                        <div class="mb-3">
                            <label for="passwordUtilisateur" class="form-label">Mot de passe :</label>
                            <input type="password" class="form-control" id="passwordUtilisateur" name="passwordUtilisateur">
                        </div>
                        <div class="mb-3">
                            <label for="passwordUtilisateurCheck" class="form-label">Confirmer le mot de passe :</label>
                            <input type="password" class="form-control" id="passwordUtilisateurCheck" name="passwordUtilisateurCheck">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" onclick="document.forms['creerUtilisateurForm'].submit();" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Le modal de confirmation de suppression -->
    <?php foreach ($administrateurs as $admin): ?>
        <div class="modal fade" id="confirmDeleteModal_<?php echo $admin['id_utilisateur']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer cet utilisateur <?php echo $admin['prenom']; ?> ?
                        <form id="deleteUserForm_<?php echo $admin['id_utilisateur']; ?>" action="process/deleteAdmin.php" method="post">
                            <input type="hidden" name="userId" value="<?php echo $admin['id_utilisateur']; ?>">
                            <input type="hidden" name="username" value="<?php echo $admin['prenom']; ?>">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteUserForm_<?php echo $admin['id_utilisateur']; ?>').submit();">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Le modal d'édition de l'administrateur -->
    <?php foreach ($administrateurs as $admin): ?>
        <div class="modal fade" id="editAdminModal_<?php echo $admin['id_utilisateur']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modifier l'administrateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenu du modal -->
                        <form id="editAdminForm_<?php echo $admin['id_utilisateur']; ?>" action="process/editAdmin.php" method="post">
                            <input type="hidden" name="userId" value="<?php echo $admin['id_utilisateur']; ?>"> <!-- Champ userId caché -->
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Nom :</label>
                                <input type="text" class="form-control" id="editUsername" name="editUsername" value="<?php echo $admin['nom']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editPrenom" class="form-label">Prenom :</label>
                                <input type="text" class="form-control" id="editPrenom" name="editPrenom" value="<?php echo $admin['prenom']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Adresse email :</label>
                                <input type="email" class="form-control" id="editEmail" name="editEmail" value="<?php echo $admin['email']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Nouveau mot de passe :</label>
                                <input type="password" class="form-control" id="editPassword" name="editPassword">
                            </div>
                            <div class="mb-3">
                                <label for="editConfirmPassword" class="form-label">Confirmer le nouveau mot de passe :</label>
                                <input type="password" class="form-control" id="editConfirmPassword" name="editConfirmPassword">
                            </div>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" onclick="document.getElementById('editAdminForm_<?php echo $admin['id_utilisateur']; ?>').submit();" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Le modal de détails de l'administrateur -->
    <?php foreach ($administrateurs as $admin): ?>
        <div class="modal fade" id="detailsAdminModal_<?php echo $admin['id_utilisateur']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Détails de l'administrateur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenu des détails de l'administrateur -->
                        <p><strong>ID: </strong><?php echo $admin['id_utilisateur']; ?></p>
                        <p><strong>Nom: </strong><?php echo $admin['nom']; ?></p>
                        <p><strong>Prenom: </strong><?php echo $admin['prenom']; ?></p>
                        <p><strong>Email: </strong><?php echo $admin['email']; ?></p>
                        <p><strong>Date de création: </strong><?php echo $admin['administrateur']; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-qDD3ymFpkHcg6C3rJxnGvD9fSLcWRwB5PZuL8kNGpuD3IiHz5yo1Eo9XQrtwpIdX" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
