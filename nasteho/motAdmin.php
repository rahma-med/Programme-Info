<?php
// Mot de passe en clair
$mot_de_passe = 'naziyxa';

// Hacher le mot de passe
$mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

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

// Insertion dans la table administrateur
$sql = "INSERT INTO administrateur (nom, prenom, email, mot_de_passe, date_creation, statut) 
        VALUES ('Abdi', 'Nasteho', 'nastehoabdi@gmail.com', '$mot_de_passe_hache', NOW(), 'actif')";

if ($conn->query($sql) === TRUE) {
    echo "Nouveau record administrateur créé avec succès";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
