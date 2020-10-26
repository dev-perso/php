document.addEventListener("DOMContentLoaded", function()
{
    var body        = document.querySelector("body");
    var login       = document.getElementById("login");
    var search      = document.getElementById("search");
    var overlay     = document.getElementById("overlay");
    var close       = document.getElementById("closeOverlay");
    var searchBar   = document.getElementById("searchBar");
    var searchBtn   = document.getElementById("searchBtn");
    var spinner     = document.getElementById("spinner");
    var request     = new XMLHttpRequest();

    var showSearchBar = () =>
    {
        overlay.style.display = "block";
        body.style.overflow = "hidden";
    };

    var hideSearchBar = () =>
    {
        overlay.style.display = "none";
        body.style.overflow = null;
    };

    /*var searchWine = (search) =>
    {
        showSpinner();
        getFilteredWines(search);
        // TODO : Requête SQL sur la recherche
            // TODO : Sur quels éléments ?
        // TODO : filtrer sur la recherche
        hideSearchBar();
        hideSpinner();
    };*/

    /*var showSpinner = () =>
    {
        spinner.style.display = "block";
    };

    var hideSpinner = () =>
    {
        spinner.style.display = "none";
    };*/

    /*var getFilteredWines = (search) =>
    {
        var url = "/caveavin/filtre/";

        // Prépare la requête ajax
        request.open('POST', url, true);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send();

        request.onreadystatechange = function()
        {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200)
            {
                const response      = JSON.parse(request.response);
                console.log("response search", response);
                var buttonFilter    = document.createElement('button');
                var span            = document.createElement('span');
                var valueToDisplay  = "";

                // Création button du filtre actif
                constraint == "cote_rhone" ? valueToDisplay = "Côte du rhône" : valueToDisplay = constraint;

                span.innerText = valueToDisplay.charAt(0).toUpperCase() + valueToDisplay.slice(1);
                buttonFilter.classList.add('actif-filtre');
                buttonFilter.setAttribute("data-filter", response['filters'][0]);
                buttonFilter.appendChild(span);
                actifFilter.appendChild(buttonFilter);
                buttonFilter.addEventListener("click", removeFilter, false);

                refreshTable(response);

                // Update des filtres actifs en cours
                actifFiltre.value != "" ?
                    actifFiltre.value = actifFiltre.value + "--" + response['filters'][0] : actifFiltre.value = response['filters'];
            }
        };

        request.onerror = () =>
            // only triggers if the request couldn't be made at all
            console.log("Erreur recherche sur " + search);
    };*/

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
            window.location.href = '/caveavin?search=' + searchBar.value;
    }, false);
    searchBtn.addEventListener("click", (e) => searchWine(searchBar.value), false);


});
