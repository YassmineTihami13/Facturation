<?php
include '../BD/connexion.php';

$sql = "SELECT * FROM consommation_mensuelle";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $id_client = $row['ID_Client'];
    $mois = $row['Mois'];
    $annee = $row['Année'];
    $valeur = $row['Valeur_Compteur'];

    $sql_prev = "SELECT Valeur_Compteur FROM consommation_mensuelle 
                 WHERE ID_Client=$id_client AND Mois=$mois-1 AND Année=$annee";
    $prev = $conn->query($sql_prev)->fetch_assoc();

    if ($prev && ($valeur - $prev['Valeur_Compteur'] > 100)) {
        echo "Alerte : Consommation anormale pour le client $id_client ($valeur kWh).";
    }
}
?>
