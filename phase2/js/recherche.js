document.addEventListener("DOMContentLoaded", () => {
  const select = document.getElementById("tri");
  const voyages = Array.from(document.querySelectorAll(".voyage-item"));
  const container = document.querySelector(".flexbox");

  select.addEventListener("change", () => {
    // Copie de la liste des voyages
    let sorted = [...voyages];

    if (select.value === "prix") {
      sorted.sort((a, b) => parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix));
    } else if (select.value === "date") {
      sorted.sort((a, b) => new Date(a.dataset.date) - new Date(b.dataset.date));
    } else if (select.value === "duree") {
      sorted.sort((a, b) => parseInt(a.dataset.duree) - parseInt(b.dataset.duree));
    }

    // Vider le container et réafficher les voyages triés
    container.innerHTML = "";
    sorted.forEach(v => container.appendChild(v));
  });
});
