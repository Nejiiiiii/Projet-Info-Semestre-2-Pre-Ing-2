session_start();

if (!isset($_SESSION["user_id"])) {
    die("Vous devez être connecté pour ajouter un voyage au panier.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $voyage_id = $_POST["voyage_id"];
    $nb_personnes = $_POST["nb_personnes"];
    $hebergement = $_POST["hebergement"];
    $transport = $_POST["transport"];
    $activites = $_POST["activites"] ?? [];

    // Ajouter au panier en session
    if (!isset($_SESSION["panier"])) {
        $_SESSION["panier"] = [];
    }

    $_SESSION["panier"][] = [
        "voyage_id" => $voyage_id,
        "nb_personnes" => $nb_personnes,
        "hebergement" => $hebergement,
        "transport" => $transport,
        "activites" => $activites
    ];

    echo "Voyage ajouté au panier avec succès.";
}
