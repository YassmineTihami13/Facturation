<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="dashboard.css">
    <!-- Inclusion de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* dashboard.css */
    :root {
        --sidebar-width: 250px;
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --hover-color: #2980b9;
        --background-color: #f8f9fa;
        --text-color: #333;
        --success-color: #2ecc71;
    }

    body {
        background-color: var(--background-color);
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', system-ui, sans-serif;
        line-height: 1.6;
    }

    .dashboard {
        margin-left: var(--sidebar-width);
        padding: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.5rem;
        transition: margin 0.3s;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        break-inside: avoid;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .card h2 {
        color: var(--primary-color);
        margin: 0 0 1.2rem;
        font-size: 1.3rem;
        font-weight: 600;
        padding-bottom: 0.8rem;
        border-bottom: 2px solid var(--secondary-color);
    }

    .card ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .card li {
        padding: 0.6rem 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card li:last-child {
        border-bottom: none;
    }

    /* Styles spécifiques au graphique */
    .chart-card {
        grid-column: 1 / -1;
        padding-bottom: 2rem;
    }

    .chart-container {
        position: relative;
        height: 400px;
        margin: 1.5rem 0;
    }

    #consumptionChart {
        max-height: 100%;
        width: 100% !important;
    }

    /* Message d'absence de données */
    .no-data {
        text-align: center;
        color: #666;
        padding: 2rem 0;
        font-style: italic;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .dashboard {
            padding: 1.5rem;
            gap: 1.2rem;
        }
    }

    @media (max-width: 768px) {
        .dashboard {
            margin-left: 60px;
            grid-template-columns: 1fr;
        }

        .chart-container {
            height: 300px;
            margin: 1rem 0;
        }

        .card {
            padding: 1.2rem;
        }

        .card h2 {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 480px) {
        .dashboard {
            padding: 1rem;
        }

        .chart-container {
            height: 250px;
        }
    }
</style>

</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="dashboard">
        <!-- Informations Personnelles -->
        <div class="card">
            <h2>Informations Personnelles</h2>
            <ul>
                <li><strong>Nom:</strong> <?php echo htmlspecialchars($client['Nom'] ?? 'Non disponible'); ?></li>
                <li><strong>Prénom:</strong> <?php echo htmlspecialchars($client['Prenom'] ?? 'Non disponible'); ?></li>
                <li><strong>Adresse:</strong> <?php echo htmlspecialchars($client['Adresse'] ?? 'Non disponible'); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($client['Email'] ?? 'Non disponible'); ?></li>
            </ul>
        </div>

        <!-- Consommations Payées -->
        <div class="card">
            <h2>Consommations Payées</h2>
            <ul>
                <?php if (!empty($factures_payees) && $factures_payees->num_rows > 0): ?>
                    <?php while ($row = $factures_payees->fetch_assoc()): ?>
                        <li>
                            Facture du <?php echo htmlspecialchars($row['Date_Facture']); ?> :
                            <?php echo htmlspecialchars($row['Consommation']); ?> kWh -
                            <?php echo htmlspecialchars($row['Montant_TTC']); ?> DH
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li>Aucune consommation payée trouvée.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Consommations Non Payées -->
        <div class="card">
            <h2>Consommations Non Payées</h2>
            <ul>
                <?php if (!empty($factures_non_payees) && $factures_non_payees->num_rows > 0): ?>
                    <?php while ($row = $factures_non_payees->fetch_assoc()): ?>
                        <li>
                            Facture du <?php echo htmlspecialchars($row['Date_Facture']); ?> :
                            <?php echo htmlspecialchars($row['Consommation']); ?> kWh -
                            <?php echo htmlspecialchars($row['Montant_TTC']); ?> DH
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li>Aucune consommation non payée trouvée.</li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Consommations Mensuelles avec Graphique -->
        <div class="card chart-card">
            <h2>Consommations Mensuelles</h2>
            <div class="chart-container">
                <canvas id="consumptionChart"></canvas>
            </div>
            <?php if (!empty($consommation_mensuelle) && $consommation_mensuelle->num_rows > 0): ?>
                <?php
                $dates = [];
                $consommations = [];
                $montants = [];
                
                while ($row = $consommation_mensuelle->fetch_assoc()) {
                    $dates[] = date('M Y', strtotime($row['Date_Facture']));
                    $consommations[] = $row['Consommation'];
                    $montants[] = $row['Montant_TTC'];
                }
                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('consumptionChart').getContext('2d');
                        
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: <?php echo json_encode($dates); ?>,
                                datasets: [{
                                    label: 'Consommation (kWh)',
                                    data: <?php echo json_encode($consommations); ?>,
                                    borderColor: '#3498db',
                                    tension: 0.4,
                                    yAxisID: 'y'
                                },
                                {
                                    label: 'Montant TTC (DH)',
                                    data: <?php echo json_encode($montants); ?>,
                                    borderColor: '#2ecc71',
                                    tension: 0.4,
                                    yAxisID: 'y1'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    }
                                },
                                scales: {
                                    y: {
                                        type: 'linear',
                                        display: true,
                                        position: 'left',
                                        title: {
                                            display: true,
                                            text: 'kWh'
                                        }
                                    },
                                    y1: {
                                        type: 'linear',
                                        display: true,
                                        position: 'right',
                                        title: {
                                            display: true,
                                            text: 'DH'
                                        },
                                        grid: {
                                            drawOnChartArea: false
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
            <?php else: ?>
                <p>Aucune donnée de consommation mensuelle disponible.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>