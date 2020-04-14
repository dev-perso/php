document.addEventListener("DOMContentLoaded", function()
{
    var macave      = document.getElementById("macave");
    var actifFilter = document.getElementById("actifFilter");
    var tr          = document.getElementsByTagName("tr");
    var use         = document.getElementsByClassName("useWine");
    var edit        = document.getElementsByClassName("editWine");
    var filter      = document.getElementsByClassName("btnFilter");
    var request     = new XMLHttpRequest();

    function editWine()
    {
        var id = this.getAttribute('id').substring(4);
        if (id != null)
        {
            window.location.href = '/caveavin/gestion/modifier/' + id;
        }
    }

    function useWine()
    {
        var id = this.getAttribute('id').substring(3);
        if (id != null)
        {
            window.location.href = '/caveavin/gestion/utiliser/' + id;
        }
    }

    function getDescription()
    {
        var id = this.getAttribute("data-id")
        if (id != null)
        {
            window.location.href = '/caveavin/bouteille/' + id;
        }
    }

    function removeFilter()
    {
        var toRemove        = this.getAttribute("data-filter");
        var currentFilter   = document.getElementById("filtres");
        var actifFiltre     = currentFilter.value.split("--");
        var newFilter       = "";
        var url             = "/caveavin/filtre/";
        var valueToDisplay  = "";

        // Bloque le filtre des autres boutons
        lockFilter(filter);
        // Bloque le filtre des boutons pour retirer les filtres
        lockActifFilter();

        for (var i = 0; i < actifFiltre.length; i++)
        {
            if (actifFiltre[i] != toRemove)
                newFilter += actifFiltre[i] + "--";
        }
        if (newFilter != "")
        {
            newFilter = newFilter.substring(0, newFilter.length - 2);
            url += newFilter;
        }
        else
        {
            url += "noFilter";
        }
        
        request.open('POST', url, true);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send();
        
        request.onreadystatechange = function()
        {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200)
            {
                const response      = JSON.parse(request.response);
                var tableBody       = document.getElementById("macave");
                let newTableBody    = "";

                // Suppression des lignes du tableau
                tableBody.innerHTML = "";

                response['wines'].forEach((wine) =>
                {
                    newTableBody += "<tr>";
                    if (wine.entityRegion.region == "cote_rhone") wine.entityRegion.region = "Côte du rhône";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.entityRegion.region.charAt(0).toUpperCase() + wine.entityRegion.region.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.entityCouleur.couleur.charAt(0).toUpperCase() + wine.entityCouleur.couleur.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.appellation.charAt(0).toUpperCase() + wine.appellation.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.annee + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.quantity + "</td>";
                    if (wine.prix != null)
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.prix + "</td>";
                    else
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">NC</td>";
                    if (wine.note != null)
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.note + "</td>";
                    else
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\"></td>";
                    newTableBody += "<td><img src=\"../img/modifier.png\" class=\"editWine\" id=\"edit" + wine.idVin + "\" title=\"Modifier\" height=\"30px\" width=\"30px\" />" +
                                    "<img src=\"../img/utiliser.png\" class=\"useWine ml-3\" id=\"use" + wine.idVin + "\" title=\"Utiliser\" height=\"30px\" width=\"30px\" /></td>";
                    newTableBody += "</tr>";
                });

                tableBody.innerHTML = newTableBody;

                var edit    = document.getElementsByClassName("editWine");
                var use     = document.getElementsByClassName("useWine");
                var tr          = document.getElementsByTagName("tr");

                // Débloque les boutons des filtres
                unlockFilter(filter);
                // Permet d'obtenir la description des vins dans le tableau
                getDescription(tr);
                // Crée les événements d'édition du vin
                editWine(edit);
                // Crée les événements d'utilisation du vin
                useWine(use);
                // Débloque les boutons pour retirer les filtres
                unlockActifFilter();
                
                // Réécris dans l'input hidden des filtres en cours
                if (currentFilter.value != "")
                    currentFilter.value = newFilter;
                else
                    currentFilter.value = "";

                // Créer le nouveau bouton du filtre disponible
                var buttonFilter    = document.createElement('button');
                var filterLine      = document.getElementById("filterLine");

                // Création button du filtre actif
                if (toRemove == "cote_rhone") valueToDisplay = "Côte du rhône";
                else valueToDisplay = toRemove;
                buttonFilter.innerText = valueToDisplay.charAt(0).toUpperCase() + valueToDisplay.slice(1);
                buttonFilter.className = 'btn btn-light btnFilter ml-1';
                buttonFilter.setAttribute("data-filter", toRemove);
                buttonFilter.setAttribute("role", "button");
                buttonFilter.addEventListener("click", filterMyCave, false);
                filterLine.appendChild(buttonFilter);
            }
        };

        currentFilter.value = newFilter;
        this.remove();
    }
    
    function filterMyCave()
    {
        var constraint  = this.getAttribute("data-filter");
        var actifFiltre = document.getElementById("filtres");
        var url         = "/caveavin/filtre/";

        // Bloque le filtre des boutons de filtrage
        lockFilter(filter);
        // Bloque le filtre des boutons pour retirer les filtres
        lockActifFilter();

        if (actifFiltre.value != "")
            url += constraint + "--" + actifFiltre.value;
        else
            url += constraint;
           
        this.remove();

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
                var tableBody       = document.getElementById("macave");
                let newTableBody    = "";
                var valueToDisplay  = "";

                // Création button du filtre actif
                if (constraint == "cote_rhone") valueToDisplay = "Côte du rhône";
                else valueToDisplay = constraint;
                span.innerText = valueToDisplay.charAt(0).toUpperCase() + valueToDisplay.slice(1);
                buttonFilter.classList.add('actif-filtre');
                buttonFilter.setAttribute("data-filter", response['filters'][0]);
                buttonFilter.appendChild(span);
                actifFilter.appendChild(buttonFilter);
                buttonFilter.addEventListener("click", removeFilter, false);

                // Suppression des lignes du tableau
                tableBody.innerHTML = "";

                response['wines'].forEach((wine) =>
                {
                    newTableBody += "<tr>";
                    if (wine.entityRegion.region == "cote_rhone") wine.entityRegion.region = "Côte du rhône";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.entityRegion.region.charAt(0).toUpperCase() + wine.entityRegion.region.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.entityCouleur.couleur.charAt(0).toUpperCase() + wine.entityCouleur.couleur.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.appellation.charAt(0).toUpperCase() + wine.appellation.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.annee + "</td>";
                    newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.quantity + "</td>";
                    if (wine.prix != null)
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.prix + "</td>";
                    else
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">NC</td>";
                    if (wine.note != null)
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\">" + wine.note + "</td>";
                    else
                        newTableBody += "<td data-id=" + wine.idVin + " class=\"pointer\"></td>";
                    newTableBody += "<td><img src=\"../img/modifier.png\" class=\"editWine\" id=\"edit" + wine.idVin + "\" title=\"Modifier\" height=\"30px\" width=\"30px\" />" +
                                    "<img src=\"../img/utiliser.png\" class=\"useWine ml-3\" id=\"use" + wine.idVin + "\" title=\"Utiliser\" height=\"30px\" width=\"30px\" /></td>";
                    newTableBody += "</tr>";
                });

                tableBody.innerHTML = newTableBody;

                var edit    = document.getElementsByClassName("editWine");
                var use     = document.getElementsByClassName("useWine");
                var tr      = document.getElementsByTagName("tr");

                // Débloque les boutons des filtres
                unlockFilter(filter);
                // Permet d'obtenir la description des vins dans le tableau
                getDescription(tr);
                // Crée les événements d'édition du vin
                editWine(edit);
                // Crée les événements d'utilisation du vin
                useWine(use);
                // Débloque les boutons pour retirer les filtres
                unlockActifFilter();
                
                if (actifFiltre.value != "")
                    actifFiltre.value = actifFiltre.value + "--" + response['filters'][0];
                else
                    actifFiltre.value = response['filters'];
                    
            }
            
        };
    
        request.onerror = function()
        { // only triggers if the request couldn't be made at all
            console.log("Erreur requête ajax sur le Filtre Dropdown");
        };
    
        request.onprogress = function(event)
        {
            //console.log("Reçu " + event.loaded + " sur " + event.total);
        };
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
    var useWine = (use) =>
    {
        for (var i = 0; i < use.length; i++)
        {
            use[i].addEventListener("click", useWine, false);
        }
    }

    // Crée l'événement d'édition d'un vin
    var editWine = (edit) => 
    {
        for (var i = 0; i < edit.length; i++)
        {
            edit[i].addEventListener("click", editWine, false);
        }
    }

    // Bloque l'événement de filtre des vins
    var lockFilter = (filter) =>
    {
        for (var i = 0; i < filter.length; i++)
        {
            filter[i].removeEventListener("click", filterMyCave);
        }
    }

    // Crée l'événement de filtre des vins
    var unlockFilter = (filter) =>
    {
        for (var i = 0; i < filter.length; i++)
        {
            filter[i].addEventListener("click", filterMyCave, false);
        }
    }

    // Bloque l'événement de filtre des vins
    var lockActifFilter = () =>
    {
        var btnActifFilter = document.getElementsByClassName("actif-filtre");

        for (var i = 0; i < btnActifFilter.length; i++)
        {
            btnActifFilter[i].removeEventListener("click", removeFilter);
        }
    }

    // Crée l'événement de filtre des vins
    var unlockActifFilter = () =>
    {
        var btnActifFilter = document.getElementsByClassName("actif-filtre");

        for (var i = 0; i < btnActifFilter.length; i++)
        {
            btnActifFilter[i].addEventListener("click", removeFilter, false);
        }
    }

    // Redirige vers les descriptions du vin de la ligne cliqué
    var getDescription = (tr) =>
    {
        for (var i = 0; i < tr.length; i++)
        {
            for (var j = 0; j < (tr[i].cells.length - 1); j++)
            {
                tr[i].cells[j].addEventListener("click", getDescription, false);
            }
        }
    }

    // Active les événements
    unlockFilter(filter);   // des filtres
    getDescription(tr);     // des descriptions
    editWine(edit);         // des éditions du vin
    useWine(use);           // de l'utilisation du vin

    
});