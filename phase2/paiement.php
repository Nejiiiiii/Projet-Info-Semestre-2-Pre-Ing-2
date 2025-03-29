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

$voyage_id = $reservation['voyage_id'];

// Récupère les détails du voyage
$voyage_stmt = $conn->prepare("SELECT * FROM voyages WHERE id = :voyage_id");
$voyage_stmt->bindParam(':voyage_id', $voyage_id);
$voyage_stmt->execute();
$voyage = $voyage_stmt->fetch(PDO::FETCH_ASSOC);

$montant = $reservation['montant']; // Montant à payer
?>

<!-- Affichage du récapitulatif du voyage -->
<h2>Récapitulatif de votre voyage</h2>
<p><strong>Nom du voyage : </strong><?php echo $voyage['nom']; ?></p>
<p><strong>Dates : </strong><?php echo $voyage['date_debut']; ?> - <?php echo $voyage['date_fin']; ?></p>
<p><strong>Montant à payer : </strong><?php echo $montant; ?> €</p>

<!-- Formulaire de paiement -->
<h3>Entrez vos coordonnées bancaires :</h3>
<form action="verifier_paiement.php" method="post">
    <label for="numero_carte">Numéro de carte (16 chiffres) :</label>
    <input type="text" id="numero_carte" name="numero_carte" required pattern="\d{16}" maxlength="16"><br><br>

    <label for="nom_proprietaire">Nom du propriétaire :</label>
    <input type="text" id="nom_proprietaire" name="nom_proprietaire" required><br><br>

    <label for="expiration">Expiration (MM/AAAA) :</label>
    <input type="text" id="expiration" name="expiration" required pattern="\d{2}/\d{4}"><br><br>

    <label for="cvv">Valeur de contrôle (CVV - 3 chiffres) :</label>
    <input type="text" id="cvv" name="cvv" required pattern="\d{3}" maxlength="3"><br><br>

    <input type="hidden" name="reservation_id" value="<?php echo $reservation_id; ?>">
    <input type="hidden" name="montant" value="<?php echo $montant; ?>">

    <input type="submit" value="Payer">
</form>

