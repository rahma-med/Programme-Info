<?php
// Inclure les classes PHPMailer avec le bon ordre
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Utilisation des namespaces PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Créer une instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
        $mail->SMTPAuth = true;  // Authentification SMTP
        $mail->Username = 'votre.email@gmail.com';  // Votre adresse Gmail
        $mail->Password = 'votre_mot_de_passe';  // Votre mot de passe ou mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom($email, $name);
        $mail->addAddress('nastehoabdi@gmail.com');  // Remplacez par l'email de l'administrateur

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Message de contact depuis le site web';
        $mail->Body    = "Nom: $name<br>Email: $email<br>Message: $message";
        $mail->AltBody = "Nom: $name\nEmail: $email\nMessage: $message";

        // Envoi de l'email
        if ($mail->send()) {
            echo 'Merci pour votre message. Nous vous répondrons bientôt.';
        } else {
            echo 'Une erreur est survenue, veuillez réessayer.';
        }
    } catch (Exception $e) {
        echo "Erreur: {$mail->ErrorInfo}";
    }
}
?>
