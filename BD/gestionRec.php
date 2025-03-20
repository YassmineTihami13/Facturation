<?php
require_once '../BD/connexion.php';
$success_message = '';
$error_message = '';
function insererReclamation($conn, $id_client, $type, $description) {
    $stmt = $conn->prepare("INSERT INTO reclamation (ID_Client, Type, Description, Statut, Date_Reclamation) 
                            VALUES (?, ?, ?, 'En attente', NOW())");
    $stmt->bind_param("iss", $id_client, $type, $description);
    return $stmt->execute();
}
?>