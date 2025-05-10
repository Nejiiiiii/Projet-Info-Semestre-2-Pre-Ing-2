document.addEventListener("DOMContentLoaded", function () {
    function ajouterAuPanier() {
        document.getElementById("form-panier").submit();
    }

    // Écoute les modifications pour ajouter au panier automatiquement
    document.querySelector("input[name='nb_personnes']").addEventListener("input", ajouterAuPanier);
    document.querySelector("select[name='hebergement']").addEventListener("change", ajouterAuPanier);
    document.querySelector("select[name='transport']").addEventListener("change", ajouterAuPanier);
    document.querySelectorAll("input[name='activites[]']").forEach(el => el.addEventListener("change", ajouterAuPanier));
});
