<?php
include '../BD/connexion.php';

$sql = "SELECT * FROM client";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ID_Client']}</td>
                <td>{$row['Nom']}</td>
                <td>{$row['Prenom']}</td>
                <td>{$row['Email']}</td>
                <td>
                    <a href='modifier_client.php?id={$row['ID_Client']}'>Modifier</a> | 
                    <a href='supprimer_client.php?id={$row['ID_Client']}'>Supprimer</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Aucun client trouvé.</td></tr>";
}
?>
