<?php
// Connexion à la base de données
$servername = "localhost";
$username = "nasteho";
$password = "nasteho";
$dbname = "programme_informatique";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification si les mots de passe correspondent
    if ($password !== $confirm_password) {
        echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
    } else {
        // Sécuriser le mot de passe
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO etudiants (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $email, $password_hash);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "<script>alert('Inscription réussie !');</script>";
        } else {
            echo "<script>alert('Erreur d\'inscription.');</script>";
        }

        // Fermer la requête
        $stmt->close();
    }
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion et Inscription - Etudiant</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            max-width: 1000px;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container {
            width: 48%; /* Utilisation de 48% pour les deux formulaires côte à côte */
            margin: 10px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
        }

        h2 {
            color: #3498db;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            text-align: left;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        hr {
            margin: 20px 0;
        }

        /* Responsivité */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }
            .form-container {
                width: 100%; /* Pour occuper toute la largeur sur petits écrans */
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Inscription</h1>
        <form action="inscription.php" method="POST">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required><br>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm_password">Confirmer le mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
