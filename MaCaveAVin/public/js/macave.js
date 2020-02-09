document.addEventListener("DOMContentLoaded", function()
        {
            var tr      = document.getElementsByTagName("tr");
            var use     = document.getElementsByClassName("useWine");
            var edit    = document.getElementsByClassName("editWine");

            for (var i = 0; i < use.length; i++)
            {
                use[i].addEventListener("click", useWine, false);
            }

            for (var i = 0; i < edit.length; i++)
            {
                edit[i].addEventListener("click", editWine, false);
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
        });