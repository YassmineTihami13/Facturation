<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>
    <style>
        /* factures.css */
:root {
    --sidebar-width: 250px;
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --hover-color: #2980b9;
    --background-color: #f8f9fa;
    --text-color: #333;
    --success-color: #28a745;
    --error-color: #dc3545;
}

body {
    margin-left: var(--sidebar-width);
    padding: 30px;
    background-color: var(--background-color);
    min-height: 100vh;
}

h2 {
    color: var(--primary-color);
    margin-bottom: 25px;
    font-size: 2em;
    text-align: center;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--secondary-color);
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

thead {
    background-color: var(--primary-color);
    color: white;
}

th, td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9em;
}

tr:hover {
    background-color: #f8f9fa;
}

img {
    max-width: 100px;
    max-height: 100px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

img:hover {
    transform: scale(1.8);
    z-index: 100;
    position: relative;
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

button {
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 500;
}

.voir {
    background-color: var(--secondary-color);
    color: white;
}

.voir:hover {
    background-color: var(--hover-color);
    transform: translateY(-2px);
}

.payer {
    background-color: var(--success-color);
    color: white;
}

.payer:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
}

.payer:not(:disabled):hover {
    background-color: #218838;
    transform: translateY(-2px);
}

p {
    text-align: center;
    color: var(--error-color);
    font-size: 1.2em;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Responsive Design */
@media (max-width: 1200px) {
    body {
        padding: 20px;
    }
    
    table {
        display: block;
        overflow-x: auto;
    }
}

@media (max-width: 768px) {
    body {
        margin-left: 60px;
        padding: 15px;
    }

    h2 {
        font-size: 1.5em;
    }

    th, td {
        padding: 10px;
        font-size: 0.9em;
    }

    .action-buttons {
        flex-direction: column;
        gap: 5px;
    }

    button {
        padding: 6px 10px;
        font-size: 0.85em;
    }
}
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    <h2>Liste de vos Factures</h2>

    <?php if ($factures->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Facture</th>
                    <th>Date</th>
                    <th>Consommation</th>
                    <th>Montant HT</th>
                    <th>Montant TTC</th>
                    <th>Photo du Compteur</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($facture = $factures->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($facture['ID_Facture']); ?></td>
                        <td><?php echo htmlspecialchars($facture['Date_Facture']); ?></td>
                        <td><?php echo htmlspecialchars($facture['Consommation']); ?> kWh</td>
                        <td><?php echo htmlspecialchars($facture['Montant_HT']); ?> MAD</td>
                        <td><?php echo htmlspecialchars($facture['Montant_TTC']); ?> MAD</td>
                        <td>
                            <?php if (!empty($facture['Photo_Compteur'])): ?>
                                <img src="<?php echo htmlspecialchars($facture['Photo_Compteur']); ?>" alt="Photo Compteur">
                            <?php else: ?>
                                Aucune photo
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($facture['statut'] ?? 'Non défini'); ?></td>
                        <td>
                            <div class="action-buttons">
                                <!-- Bouton Voir -->
                                <button class="voir" onclick="window.location.href='../Traitement/traitementTemplate.php?id=<?php echo $facture['ID_Facture']; ?>'">Voir</button>
                                <!-- Bouton Payer -->
                                <?php if ($facture['statut'] !== 'Payée'): ?>
                                    <button class="payer" onclick="payerFacture(<?php echo $facture['ID_Facture']; ?>)">Payer</button>
                                <?php else: ?>
                                    <button class="payer" disabled>Payée</button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune facture trouvée.</p>
    <?php endif; ?>

    <script>
        // Fonction pour gérer le clic sur le bouton "Voir"
        function voirFacture(idFacture) {
            alert("Voir la facture #" + idFacture);
            // Rediriger vers une page de détails de la facture
            // window.location.href = "details_facture.php?id=" + idFacture;
        }

        function payerFacture(idFacture) {
    if (confirm("Voulez-vous vraiment payer la facture #" + idFacture + " ?")) {
        // Rediriger vers la page de paiement avec l'ID de la facture
        window.location.href = "../IHM/paiement.php?id=" + idFacture;
    }
}
    </script>
</body>
</html>