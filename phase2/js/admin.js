document.addEventListener("DOMContentLoaded", () => {
  const actions = document.querySelectorAll(".admin-action");

  actions.forEach(form => {
    form.addEventListener("submit", (e) => {
      e.preventDefault(); // Empêche l'envoi réel du formulaire

      const button = form.querySelector("button");
      const action = form.dataset.action;
      const originalText = button.textContent;

      // Visuellement désactive le bouton et indique le traitement
      button.disabled = true;
      button.textContent = "⏳ Traitement...";

      setTimeout(() => {
        if (action === "vip") {
          button.textContent = "✅ VIP !";
          button.style.backgroundColor = "#28a745"; // vert
        } else if (action === "ban") {
          button.textContent = "🚫 Banni";
          button.style.backgroundColor = "#dc3545"; // rouge
        } else {
          button.textContent = originalText;
        }

        button.disabled = true; // Reste désactivé après action
      }, 2000); // 2 secondes
    });
  });
});
