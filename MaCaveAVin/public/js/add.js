// Restricts input for the given textbox to the given inputFilter.
function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    });
}

setInputFilter(document.getElementById("cave_prix"), function(value) {
    return /^-?\d*[.,]?\d*$/.test(value); });


document.addEventListener("DOMContentLoaded", function()
{
    // Get elements type file
    const inputElement  = document.getElementById("vin_cave_0_imageFile");
    // Get the div element where preview will be added
    var preview         = document.getElementById("preview");
    var previewImg      = document.getElementById("previewImg");

    // Create event on add file
    inputElement.addEventListener("change", handleFiles, false);

    function handleFiles()
    {
        // The file to upload
        const file = this.files[0];

        // Create FileReader to prepare Object to be preview
        previewImg.src   = window.URL.createObjectURL(file);
        previewImg.style.display = "inline";
    }
});