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
/*
document.addEventListener("DOMContentLoaded", function()
{
    const inputElement = document.getElementById("cave_imageFile");
    inputElement.addEventListener("change", handleFiles, false);
    function handleFiles() {
        const file = this.files[0];

        console.log("file before ", file);
        // Create an image
        var img = document.createElement("img");
        // Create a file reader
        var reader = new FileReader();
        // Set the image once loaded into file reader
        reader.onload = function(e)
        {
            img.src = e.target.result;

            var canvas = document.createElement("canvas");

            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0);

            var MAX_WIDTH = 400;
            var MAX_HEIGHT = 300;
            var width = img.width;
            var height = img.height;

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height;
                    height = MAX_HEIGHT;
                }
            }
            canvas.width = width;
            canvas.height = height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(img, 0, 0, width, height);

            var dataurl = canvas.toDataURL("image/png");
            inputElement.src = dataurl;
        }
        // Load files into file reader
        reader.readAsDataURL(file);
        console.log("file after ", file);
    }*/
//});