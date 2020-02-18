document.addEventListener("DOMContentLoaded", function()
{
    var tr      = document.getElementsByTagName("tr");
    var use     = document.getElementsByClassName("useWine");
    var edit    = document.getElementsByClassName("editWine");
    var filter  = document.getElementsByClassName("btnFilter");
    var request = new XMLHttpRequest();

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
        var constraint = this.getAttribute("data-filter");
        alert(constraint);

        /*request.open('POST', url, true);
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.withCredentials = true;
        request.send(paramsReq);
    
        request.onload = function()
        {
    
        };
    
        request.onreadystatechange = function()
        {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200)
            {
                
            }
        };
    
        request.onerror = function()
        { // only triggers if the request couldn't be made at all
            console.log("Erreur requête ajax sur le Filtre Dropdown");
        };
    
        request.onprogress = function(event)
        {
            //console.log("Reçu " + event.loaded + " sur " + event.total);
        };*/
    }
});