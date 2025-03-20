<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        /* Variables CSS */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --background-color: #f8f9fa;
            --error-color: #dc3545;
            --text-color: #333;
        }

        /* Réinitialisation et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--background-color);
            padding: 20px;
        }

        /* Conteneur principal */
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Titre */
        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }

        /* Messages d'erreur */
        .alert-error {
            background-color: #f8d7da;
            color: var(--error-color);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
        }

        /* Formulaire */
        form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        button[type="submit"] {
            background-color: var(--secondary-color);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        /* Lien d'inscription */
        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: var(--hover-color);
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 25px;
            }

            h2 {
                font-size: 1.8em;
            }

            input {
                padding: 10px 12px;
                font-size: 0.9em;
            }

            button[type="submit"] {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="../Traitement/traitementConnexion.php" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div>
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit">Se connecter</button>
        </form>

        
    </div>
</body>
</html>