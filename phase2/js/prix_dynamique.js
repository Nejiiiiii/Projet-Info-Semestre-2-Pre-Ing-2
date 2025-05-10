fetch("data/tarifs.json")
    .then(response => response.json())
    .then(tarifs => {
        function calculerPrix() {
            let nbPersonnes = parseInt(document.querySelector("input[name='nb_personnes']").value) || 1;
            let hebergement = document.querySelector("select[name='hebergement']").value;
            let transport = document.querySelector("select[name='transport']").value;
            let activites = document.querySelectorAll("input[name='activites[]']:checked");

            let prixTotal = parseFloat(document.getElementById("prix_total").dataset.prix);
            prixTotal += tarifs.hebergement[hebergement];
            prixTotal += tarifs.transport[transport];
            activites.forEach(a => prixTotal += tarifs.activites[a.value]);

            // Multiplication par le nombre de personnes
            prixTotal *= nbPersonnes;

            // Mise à jour du prix affiché
            document.getElementById("prix_total").innerText = prixTotal + " €";
        }

        // Écoute des modifications
        document.querySelector("input[name='nb_personnes']").addEventListener("input", calculerPrix);
        document.querySelector("select[name='hebergement']").addEventListener("change", calculerPrix);
        document.querySelector("select[name='transport']").addEventListener("change", calculerPrix);
        document.querySelectorAll("input[name='activites[]']").forEach(el => el.addEventListener("change", calculerPrix));

        // Initialisation du prix
        calculerPrix();
    });
