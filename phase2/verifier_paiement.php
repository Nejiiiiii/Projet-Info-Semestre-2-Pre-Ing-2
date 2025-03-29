<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté
$reservation_id = $_POST['reservation_id']; // ID de la réservation
$montant = $_POST['montant']; // Montant de la réservation

// Vérifie les coordonnées bancaires
$numero_carte = $_POST['numero_carte'];
$nom_proprietaire = $_POST['nom_proprietaire'];
$expiration = $_POST['expiration'];
$cvv = $_POST['cvv'];

// Fonction de validation basique pour simuler une vérification
function validerCoordonneesBancaires($numero_carte, $expiration, $cvv) {
    // Vérifie si le numéro de carte est valide (16 chiffres)
    if (!preg_match("/^\d{16}$/", $numero_carte)) {
        return false;
    }
    // Vérifie la date d'expiration
    $expiration_date = DateTime::createFromFormat('m/Y', $expiration);
    if ($expiration_date === false || $expiration_date < new DateTime()) {
        return false;
    }
    // Vérifie le CVV (3 chiffres)
    if (!preg_match("/^\d{3}$/", $cvv)) {
        return false;
    }
    return true;
}

if (validerCoordonneesBancaires($numero_carte, $expiration, $cvv)) {
    // Si les coordonnées bancaires sont valides, enregistre la transaction
    $conn = new PDO("mysql:host=localhost;dbname=nom_de_ton_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Met à jour la réservation en statut "payée"
    $update_stmt = $conn->prepare("UPDATE reservations SET statut = 'payée' WHERE id = :reservation_id");
    $update_stmt->bindParam(':reservation_id', $reservation_id);
    $update_stmt->execute();

    // Enregistre le paiement
    $payment_stmt = $conn->prepare("INSERT INTO paiements (reservation_id, montant, date_paiement, statut) 
                                   VALUES (:reservation_id, :montant, NOW(), 'réussi')");
    $payment_stmt->bindParam(':reservation_id', $reservation_id);
    $payment_stmt->bindParam(':montant', $montant);
    $payment_stmt->execute();

    // Redirige vers une page de confirmation de paiement
    header("Location: confirmation_paiement.php");
} else {
    // Si les coordonnées bancaires sont invalides, redirige vers une page d'erreur
    header("Location: erreur_paiement.php");
}
?>
