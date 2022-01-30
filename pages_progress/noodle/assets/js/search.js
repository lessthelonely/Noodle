document.addEventListener("DOMContentLoaded", searchBar);

function searchBar() {
    let searchBar = document.getElementById("search-input");
    
    // Enter nas barras da barra de pesquisa = click.
    searchBar.addEventListener("keyup", enterKey);
    
    try {
        let userFilterBar = document.getElementById("user-filter");
        let termFilterBar = document.getElementById("term-filter");
        userFilterBar.addEventListener("keyup", enterKey);
        termFilterBar.addEventListener("keyup", enterKey);
    } catch (t) {
        console.log("NO ADVANCED FILTERING HERE!");
    }
    
    
    let magnifyingGlass = document.getElementById("magnifying-glass-link");
    magnifyingGlass.addEventListener("click", search);
}

function enterKey(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    event.preventDefault();
    document.getElementById("magnifying-glass-link").click();
  }
};

function search() {
    let searchInput = document.getElementById("search-input").value;
    let userFilter = "", termFilter = "";
    try {
        userFilter = document.getElementById("user-filter").value;
        termFilter = document.getElementById("term-filter").value;
    } catch (e) {
        console.log("Filters aren't available");
    }
    
    // Se os filtros continuarem como "", não são para ser usados.
    
    // Será exact word match?
    if (searchInput.slice(0, 1) == "\"" && searchInput.slice(searchInput.length - 1, searchInput.length) == "\"") {
        console.log("Exact Word Match!!!!!");
    }
    
    console.log("BREAKPOINT");
}