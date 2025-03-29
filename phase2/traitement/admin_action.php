<?php
session_start();

// 🔐 Vérification des droits d'accès
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {
    die("Accès refusé.");
}

$dataFile = "../data/utilisateurs.json";

// 📥 Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    $userId = intval($_POST["user_id"] ?? 0);

    if (!file_exists($dataFile)) {
        die("Fichier utilisateurs non trouvé.");
    }

    $users = json_decode(file_get_contents($dataFile), true);
    $found = false;

    foreach ($users as $index => $user) {
        if ($user["id"] === $userId) {
            $found = true;

            if ($action === "vip") {
                $users[$index]["role"] = "vip";
            } elseif ($action === "ban") {
                unset($users[$index]);
            }

            break;
        }
    }

    if ($found) {
        // Réindexation (très important si on supprime)
        $users = array_values($users);
        file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));
        header("Location: ../page7.php?success=1");
        exit;
    } else {
        die("Utilisateur non trouvé.");
    }
} else {
    die("Méthode non autorisée.");
}
?>
