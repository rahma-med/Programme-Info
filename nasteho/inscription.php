<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplacez par votre utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "programme_informatique"; // Remplacez par le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérifier si les mots de passe correspondent
    if ($password === $confirm_password) {
        // Hacher le mot de passe avant de le stocker
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Vérifier si l'email existe déjà dans la base de données avec requêtes préparées
        $stmt = $conn->prepare("SELECT * FROM etudiants WHERE email = ?");
        $stmt->bind_param("s", $email); // 's' signifie chaîne
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Un utilisateur avec cet email existe déjà!";
        } else {
            // Insertion des données dans la base de données
            $stmt = $conn->prepare("INSERT INTO etudiants (nom, prenom, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nom, $prenom, $email, $hashed_password); // 'ssss' signifie quatre chaînes
            if ($stmt->execute()) {
                echo "Inscription réussie!";
                // Rediriger vers la page de connexion après l'inscription
                header("Location: conn.html");
                exit(); // Assurez-vous que le script s'arrête ici
            } else {
                echo "Erreur: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "Les mots de passe ne correspondent pas!";
    }
}

$conn->close();
?>

