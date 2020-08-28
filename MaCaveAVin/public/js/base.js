document.addEventListener("DOMContentLoaded", function()
{
    var login  = document.getElementById("login");

    login.addEventListener("mouseenter", e =>
    {
        login.setAttribute("src", "img/connexion.png");
    });

    login.addEventListener("mouseleave", e =>
    {
        login.setAttribute("src", "img/login.svg");
    });

});
