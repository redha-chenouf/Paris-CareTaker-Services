<?php
$servername = "localhost";
$username = "root";
$password = "*******";
$dbname = "******";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $timestamp = $_POST['timestamp'];
    $id_bien = $_POST['id_bien'];

    if (!empty($uid) && !empty($timestamp) && !empty($id_bien)) {
        $sql = "INSERT INTO nfc_log (nfc_id, log_date_time, id_bien) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $uid, $timestamp, $id_bien);
        
        if ($stmt->execute() === TRUE) {
            echo "Enregistrement inséré avec succès dans la base de données locale";
        } else {
            echo "Erreur lors de l'insertion : " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Erreur : Données manquantes (UID, timestamp ou ID du bien)";
    }
} else {
    echo "Erreur : Requête non autorisée";
}

$conn->close();