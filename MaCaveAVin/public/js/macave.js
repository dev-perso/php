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

        for (var i = 0; i < actifFiltre.length; i++)
        {
            if (actifFiltre[i] != toRemove)
                newFilter += actifFiltre[i] + "--";
        }
        if (newFilter != "")
            newFilter = newFilter.substring(0, newFilter.length - 2);
        
        url += newFilter;
        
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

                response['vins'].forEach((vin) =>
                {
                    newTableBody += "<tr>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.region.charAt(0).toUpperCase() + vin.region.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.couleur.charAt(0).toUpperCase() + vin.couleur.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.appellation.charAt(0).toUpperCase() + vin.appellation.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.annee + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.quantite + "</td>";
                    if (vin.prix != null)
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.prix + "</td>";
                    else
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">NC</td>";
                    if (vin.note != null)
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.note + "</td>";
                    else
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\"></td>";
                    newTableBody += "<td><img src=\"../img/modifier.png\" class=\"editWine\" id=\"edit" + vin.id + "\" title=\"Modifier\" height=\"30px\" width=\"30px\" />" +
                                    "<img src=\"../img/utiliser.png\" class=\"useWine ml-3\" id=\"use" + vin.id + "\" title=\"Utiliser\" height=\"30px\" width=\"30px\" /></td>";
                    newTableBody += "</tr>";
                });

                tableBody.innerHTML = newTableBody;

                var edit    = document.getElementsByClassName("editWine");
                var use     = document.getElementsByClassName("useWine");

                for (var i = 0; i < edit.length; i++)
                {
                    edit[i].addEventListener("click", editWine, false);
                }

                for (var i = 0; i < use.length; i++)
                {
                    use[i].addEventListener("click", useWine, false);
                }
                
                if (actifFiltre.value != "")
                    actifFiltre.value = actifFiltre.value + "--" + response['filtres'][0];
                else
                    actifFiltre.value = response['filtres'];
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

                // Création button du filtre actif
                span.innerText = response['filtres'][0].charAt(0).toUpperCase() + response['filtres'][0].slice(1);
                buttonFilter.classList.add('actif-filtre');
                buttonFilter.setAttribute("data-filter", response['filtres'][0]);
                buttonFilter.appendChild(span);
                actifFilter.appendChild(buttonFilter);
                buttonFilter.addEventListener("click", removeFilter, false);

                // Suppression des lignes du tableau
                tableBody.innerHTML = "";

                response['vins'].forEach((vin) =>
                {
                    newTableBody += "<tr>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.region.charAt(0).toUpperCase() + vin.region.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.couleur.charAt(0).toUpperCase() + vin.couleur.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.appellation.charAt(0).toUpperCase() + vin.appellation.slice(1) + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.annee + "</td>";
                    newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.quantite + "</td>";
                    if (vin.prix != null)
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.prix + "</td>";
                    else
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">NC</td>";
                    if (vin.note != null)
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\">" + vin.note + "</td>";
                    else
                        newTableBody += "<td data-id=" + vin.id + " class=\"pointer\"></td>";
                    newTableBody += "<td><img src=\"../img/modifier.png\" class=\"editWine\" id=\"edit" + vin.id + "\" title=\"Modifier\" height=\"30px\" width=\"30px\" />" +
                                    "<img src=\"../img/utiliser.png\" class=\"useWine ml-3\" id=\"use" + vin.id + "\" title=\"Utiliser\" height=\"30px\" width=\"30px\" /></td>";
                    newTableBody += "</tr>";
                });

                tableBody.innerHTML = newTableBody;

                var edit    = document.getElementsByClassName("editWine");
                var use     = document.getElementsByClassName("useWine");

                for (var i = 0; i < edit.length; i++)
                {
                    edit[i].addEventListener("click", editWine, false);
                }

                for (var i = 0; i < use.length; i++)
                {
                    use[i].addEventListener("click", useWine, false);
                }
                
                if (actifFiltre.value != "")
                    actifFiltre.value = actifFiltre.value + "--" + response['filtres'][0];
                else
                    actifFiltre.value = response['filtres'];
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

    for (var i = 0; i < use.length; i++)
    {
        use[i].addEventListener("click", useWine, false);
    }

    for (var i = 0; i < edit.length; i++)
    {
        edit[i].addEventListener("click", editWine, false);
    }

    for (var i = 0; i < filter.length; i++)
    {
        filter[i].addEventListener("click", filterMyCave, false);
    }

    for (var i = 0; i < tr.length; i++)
    {
        for (var j = 0; j < (tr[i].cells.length - 1); j++)
        {
            tr[i].cells[j].addEventListener("click", getDescription, false);
        }
    }
});