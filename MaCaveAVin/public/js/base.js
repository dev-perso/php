document.addEventListener("DOMContentLoaded", function()
{
    var body        = document.querySelector("body");
    var login       = document.getElementById("login");
    var search      = document.getElementById("search");
    var overlay     = document.getElementById("overlay");
    var close       = document.getElementById("closeOverlay");
    var searchBar   = document.getElementById("searchBar");
    var spinner     = document.getElementById("spinner");

    var showSearchBar = () =>
    {
        overlay.style.display = "block";
        body.style.overflow = "hidden";
    }

    var hideSearchBar = () =>
    {
        overlay.style.display = "none";
        body.style.overflow = null;
    }

    var searchWine = (search) =>
    {
        showSpinner();
        console.log("search", search);
    }

    var showSpinner = () =>
    {
        spinner.style.display = "block";
    }

    if (login)
    {
        login.addEventListener("mouseenter", e => {
            login.setAttribute("src", "img/connexion.png");
        });

        login.addEventListener("mouseleave", e => {
            login.setAttribute("src", "img/login.svg");
        });
    }

    search.addEventListener("click", showSearchBar, false);
    close.addEventListener("click", hideSearchBar, false);
    searchBar.addEventListener('keypress', (e) => {
        if (e.key === 'Enter')
            searchWine(searchBar.value);
    }, false);


});
