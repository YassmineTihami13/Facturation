<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Réclamation</title>
    <style>
        /* Styles généraux */
        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --background-color: #f8f9fa;
            --success-color: #28a745;
            --error-color: #dc3545;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            margin-left: var(--sidebar-width);
            padding: 30px;
            background-color: var(--background-color);
            min-height: 100vh;
        }

        /* Conteneur principal */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* Titre */
        h1 {
            color: var(--primary-color);
            font-size: 2.2em;
            margin-bottom: 30px;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--secondary-color);
        }

        /* Messages d'alerte */
        .alert {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            font-size: 0.95em;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        /* Formulaire */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-weight: 500;
        }

        select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        select:focus, textarea:focus {
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
            font-size: 1em;
            transition: all 0.3s ease;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                margin-left: 60px;
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8em;
            }

            select, textarea {
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            button[type="submit"] {
                padding: 10px 15px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="container">
        <h1>Ajouter une Réclamation</h1>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="type">Type de réclamation</label>
                <select id="type" name="type" required>
                    <option value="Fuite externe">Fuite externe</option>
                    <option value="Fuite interne">Fuite interne</option>
                    <option value="Facture">Facture</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required></textarea>
            </div>
            <button type="submit">Soumettre la réclamation</button>
        </form>
    </div>
</body>
</html>