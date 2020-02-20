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
    
    function filterMyCave()
    {
        var constraint  = this.getAttribute("data-filter");
        var url         = "/caveavin/filtre/" + constraint;

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

                // Création button du filtre actif
                span.innerText = response['filtres'];
                buttonFilter.classList.add('actif-filtre');
                buttonFilter.appendChild(span);
                actifFilter.appendChild(buttonFilter);

                
                console.log(buttonFilter);



                console.log(JSON.parse(request.response));

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