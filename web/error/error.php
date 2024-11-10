<?php

function error($id) {
    if ($id == 1) {
        echo "<div class='alert alert-danger' role='alert'>Identifiant incorrect</div>";
    } elseif ($id == 2) {
        echo "<div class='alert alert-danger' role='alert'>Erreur</div>";
    } else {
        exit;
    }
}