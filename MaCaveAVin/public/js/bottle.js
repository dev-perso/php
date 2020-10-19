document.addEventListener("DOMContentLoaded", function()
{
    var edit    = document.getElementsByClassName("editBtn");
    var use     = document.getElementsByClassName("useBtn");

    function editWine()
    {
        var id = this.getAttribute('id').substring(4);
        console.log("id", id);
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

    // Crée l'événement d'édition d'un vin
    var eventBtnEditWine = (edit) =>
    {
        for (var i = 0; i < edit.length; i++)
            edit[i].addEventListener("click", editWine, false);
    }

    // Crée l'événement d'utilisation d'un vin
    var eventBtnUseWine = (use) =>
    {
        for (var i = 0; i < use.length; i++)
            use[i].addEventListener("click", useWine, false);
    }

    eventBtnEditWine(edit);     // des éditions du vin
    eventBtnUseWine(use);       // de l'utilisation du vin
});