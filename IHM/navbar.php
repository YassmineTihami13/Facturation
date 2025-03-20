<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="../Traitement/traitementDashboard.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="../Traitement/traitementFacture.php" class="nav-link">Afficher Factures</a></li>
            <li class="nav-item"><a href="../Traitement/traitementCons.php" class="nav-link">Saisir Consommation</a></li>
            <li class="nav-item"><a href="../Traitement/traitementRec.php" class="nav-link">Faire Réclamation</a></li>
            <li class="nav-item"><a href="../Traitement/logout.php" class="nav-link">Logout</a></li>
        </ul>
    </nav>
</body>
</html>




<style>
    /* navbar.css */
:root {
    --sidebar-width: 250px;
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --hover-color: #2980b9;
}

.navbar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: var(--sidebar-width);
    background-color: var(--primary-color);
    padding: 20px 0;
    transition: 0.3s;
    z-index: 1000;
}

.nav-list {
    list-style: none;
    padding: 0 15px;
}

.nav-item {
    margin: 8px 0;
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 16px;
}

.nav-link:hover,
.nav-link.active {
    background-color: var(--hover-color);
    transform: translateX(5px);
}

.nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    width: 3px;
    height: 100%;
    background-color: var(--secondary-color);
    opacity: 0;
    transition: opacity 0.3s;
}

.nav-link:hover::before {
    opacity: 1;
}

@media (max-width: 768px) {
    .navbar {
        width: 60px;
        padding: 10px 0;
    }
    .nav-link span {
        display: none;
    }
    .nav-link {
        padding: 15px;
        justify-content: center;
    }
}
</style>