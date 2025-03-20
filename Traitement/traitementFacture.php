<?php
session_start();
include('../BD/gestionFacture.php'); 
if (!isset($_SESSION['client_id'])) {
    header("Location: traitementConnexion.php");
    exit();
}
$client_id = $_SESSION['client_id'];
$factures = getFactures($client_id);
include('../IHM/listeFactures.php');
?>