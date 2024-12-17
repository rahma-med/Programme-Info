<?php

// Connexion à la base de données
$servername = "localhost";
$username = "nasteho";
$password = "nasteho";
$dbname = "programme_informatique";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Connexion échouée à la base de données: " . $conn->connect_error);
}

// Démarrer la session pour gérer la connexion de l'utilisateur
session_start();

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs du formulaire sont définis et non vides
    if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $email = mysqli_real_escape_string($conn, $_POST['username']); // Utilisation de 'username' ici
        $password = $_POST['password'];
        $_SESSION['password'] = $password;

        // Débogage : Afficher l'email
        echo "Email reçu : " . $email . "<br>";

        // Validation de l'email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo "Email invalide.";
            exit();
        }

        // Vérification de l'utilisateur dans la base de données pour les étudiants
        $stmt = $conn->prepare("SELECT * FROM etudiants WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si l'utilisateur n'est pas trouvé dans les étudiants, vérifier dans les administrateurs
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Vérification du mot de passe pour l'étudiant avec hachage
            if (password_verify($password, $row['password'])) {
                // Connexion réussie pour l'étudiant
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['nom'] = $row['nom'];

                // Redirection vers la page programme.php
                header("Location: programme.php");
                exit();
            } else {
                echo "Mot de passe incorrect pour l'étudiant!";
            }
        } else {
            // Vérifier l'email dans la table des administrateurs
            $stmt = $conn->prepare("SELECT * FROM administrateur WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Débogage : afficher les résultats de la requête administrateur
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                var_dump($row); // Afficher les résultats du premier administrateur trouvé

                // Vérification du mot de passe pour l'administrateur avec hachage
                if (password_verify($password, $row['mot_de_passe'])) {
                    // Connexion réussie pour l'administrateur
                    $_SESSION['admin_id'] = $row['id'];
                    $_SESSION['admin_email'] = $row['email'];
                    $_SESSION['admin_nom'] = $row['nom'];

                    // Redirection vers la page d'administration
                    header("Location: testAFF.php");
                    exit();
                } else {
                    echo "Mot de passe incorrect pour l'administrateur!";
                }
            } else {
                echo "Email non trouvé.";
            }
        }

        $stmt->close();
    } else {
        echo "L'email et le mot de passe sont requis.";
    }
}

$conn->close();
?>
