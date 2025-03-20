<?php
include('connexion.php'); 
function getFactures($client_id) {
    global $conn; 
    $sql = "SELECT * FROM Facture WHERE ID_Client = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    return $stmt->get_result();
}
?>