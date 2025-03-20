<?php
include("../BD/connexion.php");

$sql = "SELECT * FROM consommation_mensuelle";
$stmt = $pdo->query($sql);
$consommations = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($consommations as $conso) {
    if ($conso['Valeur_Compteur'] > 500) { // Exemple d’anomalie
        echo "⚠️ Anomalie détectée pour le client ID " . $conso['ID_Client'] . ": Consommation élevée (" . $conso['Valeur_Compteur'] . " kWh)";
    }
}
?>
