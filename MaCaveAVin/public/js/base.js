document.addEventListener("DOMContentLoaded", function()
{
    var login   = document.getElementById("login");
    var search  = document.getElementById("search");
    var overlay = document.getElementById("overlay");

    var showSearchBar = () =>
    {

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

    search.addEventListener("click", showSearchBar);



});
