<?php
include 'connexion.php';

// Fonction pour exécuter les requêtes SQL de manière sécurisée
function fetchData($conn, $sql, $params = []) {
    $stmt = $conn->prepare($sql);
    if ($params) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

// Récupérer les informations du client
function getClientInfo($conn, $client_id) {
    $sql = "SELECT * FROM client WHERE ID_Client = ?";
    $result = fetchData($conn, $sql, [$client_id]);
    return $result->fetch_assoc();
}

// Récupérer les factures payées
function getFacturesPayees($conn, $client_id) {
    $sql = "SELECT * FROM facture WHERE ID_Client = ? AND statut = 'Payée'";
    return fetchData($conn, $sql, [$client_id]);
}

// Récupérer les factures non payées
function getFacturesNonPayees($conn, $client_id) {
    $sql = "SELECT * FROM facture WHERE ID_Client = ? AND (statut IS NULL OR statut = 'Non Payée')";
    return fetchData($conn, $sql, [$client_id]);
}

// Récupérer toutes les consommations mensuelles (factures)
function getConsommationMensuelle($conn, $client_id) {
    $sql = "SELECT * FROM facture WHERE ID_Client = ? ORDER BY Date_Facture DESC";
    return fetchData($conn, $sql, [$client_id]);
}
?>