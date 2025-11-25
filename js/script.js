// Seleciona os elementos
const modal = document.getElementById("adminModal");
const linkAdm = document.getElementById("loginLink"); // O ID no menu
const btnClose = document.querySelector(".close-btn");

//abrir o pop-up ao clicar no link do menu
linkAdm.addEventListener("click", (event) => {
    event.preventDefault(); // não deixa que o site vá para outra página ou recarregue
    modal.style.display = "block"; // Mostra o pop-up que esta por padrão none no css
});

// Fecha o pop-up no X do canto
btnClose.addEventListener("click", () => {
    modal.style.display = "none";
});

//Fecha o pop-up clicando fora
window.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});
