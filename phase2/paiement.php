<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté
$reservation_id = $_GET['reservation_id']; // ID de la réservation à payer

// Connexion à la base de données
$host = 'localhost';
$dbname = 'nom_de_ton_db';
$username = 'root';
$password = '';

// Crée la connexion
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupère les détails de la réservation
$stmt = $conn->prepare("SELECT * FROM reservations WHERE id = :reservation_id AND utilisateur_id = :user_id");
$stmt->bindParam(':reservation_id', $reservation_id);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    echo "Réservation non trouvée ou vous n'avez pas accès à cette réservation.";
    exit();
}

$montant = $reservation['montant']; // Montant à payer

// Processus de paiement (remplace par l'intégration d'un service de paiement réel)
$payment_successful = processPayment($montant);

if ($payment_successful) {
    // Met à jour le statut de la réservation en "payée"
    $update_stmt = $conn->prepare("UPDATE reservations SET statut = 'payée' WHERE id = :reservation_id");
    $update_stmt->bindParam(':reservation_id', $reservation_id);
    $update_stmt->execute();

    // Enregistre l'information du paiement
    $payment_stmt = $conn->prepare("INSERT INTO paiements (reservation_id, montant, date_paiement, statut) 
                                   VALUES (:reservation_id, :montant, NOW(), 'réussi')");
    $payment_stmt->bindParam(':reservation_id', $reservation_id);
    $payment_stmt->bindParam(':montant', $montant);
    $payment_stmt->execute();

    echo "Paiement réussi. Votre réservation est confirmée.";
} else {
    // En cas d'échec du paiement
    $payment_stmt = $conn->prepare("INSERT INTO paiements (reservation_id, montant, date_paiement, statut) 
                                   VALUES (:reservation_id, :montant, NOW(), 'échoué')");
    $payment_stmt->bindParam(':reservation_id', $reservation_id);
    $payment_stmt->bindParam(':montant', $montant);
    $payment_stmt->execute();

    echo "Le paiement a échoué. Veuillez réessayer.";
}

// Fonction simulant le processus de paiement
function processPayment($amount) {
    // Remplace cette fonction par un appel à une API de paiement réel
    // Exemple : Stripe, PayPal, etc.

    // Ici, on simule toujours un paiement réussi pour la démonstration
    return true;
}
?>
