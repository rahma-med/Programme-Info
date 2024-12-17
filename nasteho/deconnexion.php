<?php
// Démarre ou reprend la session existante
session_start(); 

// Vérifier si l'utilisateur est bien connecté (si la session est active)
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: conn.html");
    exit();
}

// Supprimer toutes les variables de session
session_unset();

// Détruire la session côté serveur
session_destroy();

// Si PHP utilise des cookies pour la session, on les supprime également pour plus de sécurité
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    // Supprimer le cookie de session
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Rediriger l'utilisateur vers la page de connexion après la déconnexion
header("Location: conn.html");
exit();
?>

