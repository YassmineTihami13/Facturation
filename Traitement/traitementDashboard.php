<?php
session_start();
if (!isset($_SESSION['client_id'])) {
    header("Location: ../IHM/connexion.php");
    exit();
}

$client_id = $_SESSION['client_id'];

include '../BD/gestionDashboard.php'; // Inclure avant l'accès aux fonctions

// Récupérer les données
$client = getClientInfo($conn, $client_id);
$factures_payees = getFacturesPayees($conn, $client_id);
$factures_non_payees = getFacturesNonPayees($conn, $client_id);
$consommation_mensuelle = getConsommationMensuelle($conn, $client_id);

// Sécuriser les variables pour éviter les erreurs d'affichage
$factures_payees = $factures_payees ?: new mysqli_result(); 
$factures_non_payees = $factures_non_payees ?: new mysqli_result();
$consommation_mensuelle = $consommation_mensuelle ?: new mysqli_result();

// Maintenant, inclure la vue
include '../IHM/DashboardClient.php';

// Vérifier si les variables sont définies
if (!$factures_payees) {
    $factures_payees = []; // Initialiser à un tableau vide si null
}
if (!$factures_non_payees) {
    $factures_non_payees = []; // Initialiser à un tableau vide si null
}
if (!$consommation_mensuelle) {
    $consommation_mensuelle = []; // Initialiser à un tableau vide si null
}
?>