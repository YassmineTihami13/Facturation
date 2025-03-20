<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription Fournisseur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h1>Connectez vous si vous avez deja un compte ! ou Inscrivez vous</h1>
        
        <!-- Afficher les messages de succès ou d'erreur -->
        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="message success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="message error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <!-- Onglets de navigation -->
        <div class="tabs">
            <button class="tab-button" onclick="showForm('login')">Se connecter</button>
            <button class="tab-button" onclick="showForm('register')">S'inscrire</button>
        </div>

        <!-- Formulaire de connexion -->
        <div id="login" class="form-section">
            <form action="../Traitement/login_traitement.php" method="POST">
                <input type="hidden" name="type" value="fournisseur">
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit">Se connecter</button>
            </form>
        </div>

        <!-- Formulaire d'inscription -->
        <div id="register" class="form-section" style="display: none;">
            <form action="../Traitement/inscription_traitement.php" method="POST">
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" required><br><br>

                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom" required><br><br>

                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <label for="mot_de_passe">Mot de passe :</label><br>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

                <label for="confirm_mot_de_passe">Confirmer le mot de passe :</label><br>
                <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe" required><br><br>

                <input type="submit" value="S'inscrire">
            </form>
        </div>
    </div>

    <script>
        // Fonction pour afficher le formulaire de connexion ou d'inscription
        function showForm(formType) {
            if (formType === 'login') {
                document.getElementById('login').style.display = 'block';
                document.getElementById('register').style.display = 'none';
            } else {
                document.getElementById('login').style.display = 'none';
                document.getElementById('register').style.display = 'block';
            }
        }
    </script>
</body>
</html>
