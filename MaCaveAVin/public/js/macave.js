document.addEventListener("DOMContentLoaded", function()
{
    var macave      = document.getElementById("macave");
    var actifFilter = document.getElementById("actifFilter");
    var tr          = document.getElementsByTagName("tr");
    var use         = document.getElementsByClassName("useWine");
    var edit        = document.getElementsByClassName("editWine");
    var filter      = document.getElementsByClassName("btnFilter");
    var spinner     = document.getElementById("spinner");
    var request     = new XMLHttpRequest();
    var currentUrl  = new URL(window.location.href);

    var showSpinner = () =>
    {
        spinner.style.display = "block";
    };

    var hideSpinner = () =>
    {
        spinner.style.display = "none";
    };

    // If user is searching for a wine from anywhere
    if (currentUrl.searchParams.get("search"))
    {
        var search = currentUrl.searchParams.get("search");
        var url = "/caveavin/search/" + search;

        showSpinner();

        // Prépare la requête ajax
        request.open('POST', url, true);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send();

        request.onreadystatechange = function()
        {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200)
            {
                const response = JSON.parse(request.response);
                console.log("response search", response);
                refreshTable(response);
                spinner.style.display = "none";
            }
        };
    }

    // Redirect to edit page
    function editWine()
    {
        var id = this.getAttribute('id').substring(4);
        if (id != null)
            window.location.href = '/caveavin/gestion/modifier/' + id;
    }

    // Redirect to use page
    function useWine()
    {
        var id = this.getAttribute('id').substring(3);
        if (id != null)
            window.location.href = '/caveavin/gestion/utiliser/' + id;
    }

    // Redirect to bottle information page
    function getDescription()
    {
        var id = this.getAttribute("data-id")
        if (id != null)
            window.location.href = '/caveavin/bouteille/' + id;
    }

    // Enlève un filtre
    function removeFilter()
    {
        var toRemove        = this.getAttribute("data-filter");
        var currentFilter   = document.getElementById("filtres");
        var actifFiltre     = currentFilter.value.split("--");
        var newFilter       = "";
        var url             = "/caveavin/filtre/";
        var valueToDisplay  = "";

        //Spinner
        showSpinner();
        // Bloque le filtre des autres boutons
        lockFilter(filter);
        // Bloque le filtre des boutons pour retirer les filtres
        lockActifFilter();

        for (var i = 0; i < actifFiltre.length; i++)
            if (actifFiltre[i] != toRemove)
                newFilter += actifFiltre[i] + "--";

        if (newFilter != "")
        {
            newFilter = newFilter.substring(0, newFilter.length - 2);
            url += newFilter;
        }
        else
            url += "noFilter";

        // Ajax request to get all wine filtered from user cave
        request.open('POST', url, true);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send();
        
        request.onreadystatechange = function()
        {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200)
            {
                const response      = JSON.parse(request.response);

                // Créer le nouveau bouton du filtre disponible
                var buttonFilter    = document.createElement('button');
                var filterLine      = document.getElementById("filterLine");

                refreshTable(response);
                
                // Réécris dans l'input hidden des filtres en cours
                currentFilter.value != "" ? currentFilter.value = newFilter : currentFilter.value = "";

                // Création button du filtre actif
                toRemove == "cote_rhone" ? valueToDisplay = "Côte du rhône" : valueToDisplay = toRemove;

                buttonFilter.innerText = valueToDisplay.charAt(0).toUpperCase() + valueToDisplay.slice(1);
                buttonFilter.className = 'btn btn-light btnFilter ml-1';
                buttonFilter.setAttribute("data-filter", toRemove);
                buttonFilter.setAttribute("role", "button");
                buttonFilter.addEventListener("click", addFilter, false);
                filterLine.appendChild(buttonFilter);

                // Hide spinner
                hideSpinner();
            }
        };

        currentFilter.value = newFilter;
        // Supprime le bouton du filtre actif cliqué
        this.remove();
    }

    // Filtre la cave
    function addFilter()
    {
        var constraint  = this.getAttribute("data-filter");
        var actifFiltre = document.getElementById("filtres");
        var url         = "/caveavin/filtre/";

        // Spinner
        showSpinner();
        // Bloque le filtre des boutons de filtrage
        lockFilter(filter);
        // Bloque le filtre des boutons pour retirer les filtres
        lockActifFilter();

        // Construit l'url pour la requête ajax
        actifFiltre.value != "" ? url += constraint + "--" + actifFiltre.value : url += constraint;

        // Enlève le filtre
        this.remove();

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
                var buttonFilter    = document.createElement('button');
                var span            = document.createElement('span');
                var valueToDisplay  = "";

                // Création button du filtre actif
                constraint == "cote_rhone" ? valueToDisplay = "Côte du rhône" : valueToDisplay = constraint;

                span.innerText = valueToDisplay.charAt(0).toUpperCase() + valueToDisplay.slice(1);
                buttonFilter.classList.add('actif-filtre');
                buttonFilter.setAttribute("data-filter", response['filters'][0]);
                buttonFilter.innerText = valueToDisplay.charAt(0).toUpperCase() + valueToDisplay.slice(1);
                actifFilter.appendChild(buttonFilter);
                buttonFilter.addEventListener("click", removeFilter, false);

                refreshTable(response);

                // Update des filtres actifs en cours
                actifFiltre.value != "" ?
                    actifFiltre.value = actifFiltre.value + "--" + response['filters'][0] : actifFiltre.value = response['filters'];

                hideSpinner();
            }
        };
    
        request.onerror = () =>
            // only triggers if the request couldn't be made at all
            console.log("Erreur sur le filtre " + constraint);
    }

    // Init new Table
    var refreshTable = (response) =>
    {
        console.log("table response", response);
        let newTableBody    = "";
        // Suppression des lignes du tableau
        macave.innerHTML = "";

        // Construction du nouveau tableau
        response['wines'].forEach((wine) =>
        {
            newTableBody += constructTable(wine);
        });

        // Ajout du nouveau tableau
        macave.innerHTML = newTableBody;

        var edit    = document.getElementsByClassName("editWine");
        var use     = document.getElementsByClassName("useWine");
        var tr      = document.getElementsByTagName("tr");

        // Débloque les boutons des filtres
        unlockFilter(filter);
        // Permet d'obtenir la description des vins dans le tableau
        eventGetDescription(tr);
        // Crée les événements d'utilisation du vin
        eventBtnUseWine(use);
        // Débloque les boutons pour retirer les filtres
        unlockActifFilter();
    }

    // Construction d'une ligne du tableau en fonction du vin
    var constructTable = (wine) =>
    {
        var largeString = "";
        if (wine.appellation.length > 60)
            largeString = "...";

        newTableBody = "<tr>";
        if (wine.entityRegion.region == "cote_rhone") wine.entityRegion.region = "Côte du rhône";
        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.entityRegion.region.charAt(0).toUpperCase() + wine.entityRegion.region.slice(1) + "</td>";
        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.entityCouleur.couleur.charAt(0).toUpperCase() + wine.entityCouleur.couleur.slice(1) + "</td>";
        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.appellation.charAt(0).toUpperCase() + wine.appellation.slice(1).substring(0, 59) + largeString + "</td>";
        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.annee + "</td>";
        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.quantity + "</td>";
        if (wine.prix != null)
            newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.prix + " €</td>";
        else
            newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\"></td>";
        if (wine.note != null)
            newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.note + "</td>";
        else
            newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\"></td>";
        newTableBody += "<td class=\"useWineColumn\"><img src=\"../img/utiliser.png\" class=\"useWine\" id=\"use" + wine.idVin + "\" title=\"Utiliser\" height=\"30px\" width=\"30px\" /></td>";
        newTableBody += "</tr>";

        return newTableBody;
    }

    /**
     * AddEventListener
     *
     * click sur les boutons Archive
     * click sur les boutons Edition
     * click sur les boutons Filtre
     * click sur les lignes du tableau pour Description
     */

    // Crée l'événement d'utilisation d'un vin
    var eventBtnUseWine = (use) =>
    {
        for (var i = 0; i < use.length; i++)
            use[i].addEventListener("click", useWine, false);
    }

    // Bloque l'événement de filtre des vins
    var lockFilter = (filter) =>
    {
        for (var i = 0; i < filter.length; i++)
            filter[i].removeEventListener("click", addFilter);
    }

    // Crée l'événement de filtre des vins
    var unlockFilter = (filter) =>
    {
        for (var i = 0; i < filter.length; i++)
            filter[i].addEventListener("click", addFilter, false);
    }

    // Bloque l'événement de filtre des vins
    var lockActifFilter = () =>
    {
        var btnActifFilter = document.getElementsByClassName("actif-filtre");

        for (var i = 0; i < btnActifFilter.length; i++)
            btnActifFilter[i].removeEventListener("click", removeFilter);
    }

    // Crée l'événement de filtre des vins
    var unlockActifFilter = () =>
    {
        var btnActifFilter = document.getElementsByClassName("actif-filtre");

        for (var i = 0; i < btnActifFilter.length; i++)
            btnActifFilter[i].addEventListener("click", removeFilter, false);
    }

    // Redirige vers les descriptions du vin de la ligne cliqué
    var eventGetDescription = (tr) =>
    {
        for (var i = 0; i < tr.length; i++)
            for (var j = 0; j < (tr[i].cells.length - 1); j++)
                tr[i].cells[j].addEventListener("click", getDescription, false);
    }

    /**
     * Active les événements
     */
    unlockFilter(filter);       // des filtres
    eventGetDescription(tr);    // des descriptions
    eventBtnUseWine(use);       // de l'utilisation du vin
});