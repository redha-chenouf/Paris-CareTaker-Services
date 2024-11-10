<?php
function searchFunction($inputId, $searchUrl, $type) {
    $script = <<<HTML
<script>
    document.getElementById('$inputId').addEventListener('input', async function() {
        const inputValue = this.value;
        try {
            const response = await fetch('$searchUrl?q=' + inputValue);
            
            if (!response.ok) {
                throw new Error('La requête a échoué : ' + response.status);
            }

            const data = await response.json();

            let tableHTML = "<table class='table table-striped'><thead><tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Numéro pays</th><th>Numéro téléphone</th><th>Status</th><th>Détails</th></tr></thead><tbody>";
            data.forEach(function(user) {
                let status;
                if (user["bailleur"] != null) {
                    if (user["bailleur_accept"] == 1 && user["bailleur_refus"] == 0) {
                        status = "Accepté";
                    } else if (user["bailleur_accept"] == 0 && user["bailleur_refus"] == 0) {
                        status = "En attente";
                    } else if (user["bailleur_accept"] == 0 && user["bailleur_refus"] == 1) {
                        status = "Refusé";
                    } else {
                        status = " ";
                    }
                } else if(user["prestataire"] != null) {
                    if (user["prestataire_accept"] == 1 && user["prestataire_refus"] == 0) {
                        status = "Accepté";
                    } else if (user["prestataire_accept"] == 0 && user["prestataire_refus"] == 0) {
                        status = "En attente";
                    } else if (user["prestataire_accept"] == 0 && user["prestataire_refus"] == 1) {
                        status = "Refusé";
                    } else {
                        status = " ";
                    }
                } else if (user["voyageur"] != null) {
                    if (user["bloque"] == null) {
                        status = "Bloqué";
                    } else {
                        status = "Validé";
                    }
                }

                tableHTML += "<tr>";
                tableHTML += "<td>" + user['nom'] + "</td>";
                tableHTML += "<td>" + user['prenom'] + "</td>";
                tableHTML += "<td>" + user['email'] + "</td>";
                tableHTML += "<td>" + user['pays_telephone'] + "</td>";
                tableHTML += "<td>" + user['numero_telephone'] + "</td>";
                tableHTML += "<td>" + status + "</td>";
                tableHTML += "<td><a href='bdetails.php?id=" + user['id'] + "' class='btn btn-primary'>Détails</a></td>";
                tableHTML += "</tr>";
            });
            tableHTML += "</tbody></table>";

            document.getElementById('searchResults').innerHTML = tableHTML;
        } catch (error) {
            console.error('Une erreur s\'est produite:', error);
        }
    });
</script>
HTML;
    echo $script;
}
?>
