<?php
session_start();

// Chemin du fichier JSON
$dataFile = '../data/utilisateurs.json';

// Vérifier que le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupérer les champs du formulaire
    $login = htmlspecialchars(trim($_POST["uname"] ?? ""));
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $password = $_POST["psw"] ?? "";
    $confirm = $_POST["confirm_psw"] ?? "";

    // Vérifications de base
    if (empty($login) || empty($email) || empty($password) || empty($confirm)) {
        die("Tous les champs sont obligatoires.");
    }

    if ($password !== $confirm) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Charger les utilisateurs existants
    $users = [];
    if (file_exists($dataFile)) {
        $users = json_decode(file_get_contents($dataFile), true);
    }

    // Vérifier si le login ou l'email existe déjà
    foreach ($users as $user) {
        if ($user['login'] === $login) {
            die("Nom d'utilisateur déjà pris.");
        }
        if ($user['email'] === $email) {
            die("Email déjà utilisé.");
        }
    }

    // Créer le nouvel utilisateur
    $newUser = [
        "id" => count($users) + 1,
        "login" => $login,
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT),
        "role" => "user"
    ];

    // Ajouter et enregistrer
    $users[] = $newUser;
    file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));

    // Démarrer la session utilisateur
    $_SESSION["user"] = [
        "login" => $login,
        "email" => $email,
        "role" => "user"
    ];

    // Redirection
    header("Location: ../page6.php");
    exit;
}
else {
    echo "Accès refusé.";
}
?>
