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
    var canvas          = document.getElementById("canvas");
    // Create an image to prepare the preview thumbnail
    var thumbnail       = document.createElement("img");

    // Create event on add file
    inputElement.addEventListener("change", handleFiles, false);

    function handleFiles()
    {
        // The file to upload
        const file = this.files[0];

        // Create FileReader to prepare Object to be preview
        thumbnail.src   = window.URL.createObjectURL(file);
        thumbnail.id    = "thumbnail";
        var reader      = new FileReader();
        reader.onload   = function(e) {thumbnail.src = e.target.result}

        // Add the file in the FileReader object
        reader.readAsDataURL(file);
        // Add the preview and wait that image is loaded
        preview.appendChild(thumbnail).addEventListener("load", function()
        {


        console.log(thumbnail);

        /**
         * Max dimension to resize the preview
         * @type {number}
         */
        var MAX_WIDTH   = 400;
        var MAX_HEIGHT  = 300;
        var width       = thumbnail.clientWidth;
        var height      = thumbnail.clientHeight;

        console.log(width);
        console.log("height", height);
        if (width > height) {
            if (width > MAX_WIDTH) {
                height *= MAX_WIDTH / width;
                width   = MAX_WIDTH;
            }
        } else {
            if (height > MAX_HEIGHT) {
                width *= MAX_HEIGHT / height;
                height = MAX_HEIGHT;
            }
        }

        canvas.width    = width;
        canvas.height   = height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(thumbnail, 0, 0, width, height);






        console.log("file before ", file);
        setTimeout(function() {

            console.log("width", thumbnail.offsetWidth );
        }, 100);
        console.log("width", thumbnail.offsetWidth );
    });
        // Create an image
       /* var img = document.createElement("img");
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
        */
    }
});