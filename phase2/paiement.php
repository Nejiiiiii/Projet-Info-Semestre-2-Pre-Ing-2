<?php
session_start();

// Fichier JSON pour stocker les paiements
define("PAIEMENT_FILE", "data/paiements.json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $utilisateur = $_POST["utilisateur"] ?? "";
    $voyage_id = $_POST["voyage_id"] ?? "";
    $montant = $_POST["montant"] ?? "";
    $carte_numero = $_POST["carte_numero"] ?? "";
    $carte_expiration = $_POST["carte_expiration"] ?? "";

    // Vérification basique des champs
    if (empty($utilisateur) || empty($voyage_id) || empty($montant) || empty($carte_numero) || empty($carte_expiration)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!preg_match("/^[0-9]{16}$/", $carte_numero)) {
        $message = "Numéro de carte invalide.";
    } elseif (!preg_match("/^(0[1-9]|1[0-2])\/([0-9]{2})$/", $carte_expiration)) {
        $message = "Format de date invalide (MM/AA).";
    } else {
        // Masquer le numéro de carte (seuls les 4 derniers chiffres visibles)
        $carte_masque = "**** **** **** " . substr($carte_numero, -4);
        
        // Création du paiement
        $paiement = [
            "id" => uniqid(),
            "utilisateur" => $utilisateur,
            "voyage_id" => $voyage_id,
            "montant" => (float)$montant,
            "carte_numero" => $carte_masque,
            "carte_expiration" => $carte_expiration,
            "transaction_date" => date("Y-m-d H:i:s")
        ];

        // Sauvegarde dans le fichier JSON
        $paiements = file_exists(PAIEMENT_FILE) ? json_decode(file_get_contents(PAIEMENT_FILE), true) : [];
        $paiements[] = $paiement;
        file_put_contents(PAIEMENT_FILE, json_encode($paiements, JSON_PRETTY_PRINT));

        // Redirection vers confirmation
        header("Location: confirmation.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
</head>
<body>
    <h2>Formulaire de Paiement</h2>
    <?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST">
        Nom d'utilisateur : <input type="text" name="utilisateur" required><br>
        ID du voyage : <input type="number" name="voyage_id" required><br>
        Montant : <input type="text" name="montant" required><br>
        Numéro de carte : <input type="text" name="carte_numero" maxlength="16" required><br>
        Expiration (MM/AA) : <input type="text" name="carte_expiration" maxlength="5" required><br>
        <button type="submit">Payer</button>
    </form>
</body>
</html>
