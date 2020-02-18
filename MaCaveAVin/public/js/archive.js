document.addEventListener("DOMContentLoaded", function()
{
    var tr      = document.getElementsByTagName("tr");
    var edit    = document.getElementsByClassName("editWine");
    var add     = document.getElementsByClassName("addWine");

    for (var i = 0; i < edit.length; i++)
    {
        edit[i].addEventListener("click", editWine, false);
    }

    for (var i = 0; i < add.length; i++)
    {
        add[i].addEventListener("click", addWine, false);
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

    function addWine()
    {
        var id = this.getAttribute('id').substring(3);
        if (id != null)
        {
            window.location.href = '/caveavin/gestion/remettre/' + id;
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
});