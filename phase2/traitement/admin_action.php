<?php
session_start();

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès refusé.");
}

$dataFile = "../data/utilisateurs.json";

// Vérifie que les données ont été envoyées
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $userId = intval($_POST["user_id"] ?? 0);

    if (!file_exists($dataFile)) {
        die("Fichier utilisateurs non trouvé.");
    }

    $users = json_decode(file_get_contents($dataFile), true);
    $found = false;

    foreach ($users as &$user) {
        if ($user["id"] === $userId) {
            $found = true;

            if ($action === "vip") {
                $user["role"] = "vip";
            } elseif ($action === "ban") {
                // Supprimer l'utilisateur
                $users = array_filter($users, fn($u) => $u["id"] !== $userId);
            }

            break;
        }
    }

    if ($found) {
        file_put_contents($dataFile, json_encode(array_values($users), JSON_PRETTY_PRINT));
        header("Location: ../page7.php?success=1");
        exit;
    } else {
        die("Utilisateur non trouvé.");
    }
} else {
    die("Méthode non autorisée.");
}
?>
