<?php
session_start();

// Chemin du fichier JSON
$dataFile = '../data/utilisateurs.json';

// Vérifier que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupérer les champs du formulaire
    $email = htmlspecialchars(trim($_POST["email"] ?? ""));
    $password = $_POST["psw"] ?? "";

    if (empty($email) || empty($password)) {
        die("Veuillez remplir tous les champs.");
    }

    // Charger les utilisateurs existants
    if (!file_exists($dataFile)) {
        die("Aucun utilisateur enregistré.");
    }

    $users = json_decode(file_get_contents($dataFile), true);

    // Chercher l'utilisateur correspondant
    $foundUser = null;
    foreach ($users as $user) {
        if ($user["email"] === $email) {
            $foundUser = $user;
            break;
        }
    }

    // Vérifier le mot de passe
    if ($foundUser && password_verify($password, $foundUser["password"])) {
        // Connexion réussie → créer session
        $_SESSION["user"] = [
            "id" => $foundUser["id"],
            "login" => $foundUser["login"],
            "email" => $foundUser["email"],
            "role" => $foundUser["role"]
        ];

        // Rediriger selon le rôle
        if ($foundUser["role"] === "admin") {
            header("Location: ../page7.php"); // admin
        } else {
            header("Location: ../page6.php"); // utilisateur
        }
        exit;
    } else {
        // Erreur : mauvais identifiants
        header("Location: ../page5.php?erreur=Identifiants%20incorrects");
        exit;
    }
} else {
    echo "Accès non autorisé.";
}
?>
