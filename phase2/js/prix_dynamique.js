document.addEventListener("DOMContentLoaded", function () {
    let prixBase = parseFloat(document.getElementById("prix_total").dataset.prix); // Récupération du prix initial

    // Tarifs des options
    const tarifs = {
        hebergement: { standard: 0, confort: 50, luxe: 100 },
        transport: { bus: 0, train: 30, avion: 100 },
        activites: { "Randonnée": 20, "Plongée": 50, "Visites culturelles": 30 }
    };

    function calculerPrix() {
        let nbPersonnes = parseInt(document.querySelector("input[name='nb_personnes']").value) || 1;
        let hebergement = document.querySelector("select[name='hebergement']").value;
        let transport = document.querySelector("select[name='transport']").value;
        let activites = document.querySelectorAll("input[name='activites[]']:checked");

        let prixTotal = prixBase;
        prixTotal += tarifs.hebergement[hebergement];
        prixTotal += tarifs.transport[transport];
        activites.forEach(a => prixTotal += tarifs.activites[a.value]);

        // Multiplication par le nombre de personnes
        prixTotal *= nbPersonnes;

        // Mise à jour du prix affiché
        document.getElementById("prix_total").innerText = prixTotal + " €";
    }

    // Événements sur les inputs
    document.querySelector("input[name='nb_personnes']").addEventListener("input", calculerPrix);
    document.querySelector("select[name='hebergement']").addEventListener("change", calculerPrix);
    document.querySelector("select[name='transport']").addEventListener("change", calculerPrix);
    document.querySelectorAll("input[name='activites[]']").forEach(el => el.addEventListener("change", calculerPrix));

    // Initialisation du prix
    calculerPrix();
});
