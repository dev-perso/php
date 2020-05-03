var star1 = document.getElementById("star-1");
var star2 = document.getElementById("star-2");
var star3 = document.getElementById("star-3");
var star4 = document.getElementById("star-4");
var star5 = document.getElementById("star-5");

var star = new Array(star1, star2, star3, star4, star5);

var vote = document.getElementById("vote");

star.forEach((element, index) =>
{
    var iteration = index + 1;
    element.addEventListener("click", function ()
    {
        vote.value = this.getAttribute("data-value");
        star.forEach((elm, j) =>
        {
            elm.setAttribute("src", "/img/empty-star.png");
            if (j < this.getAttribute("data-value"))
                elm.setAttribute("src", "/img/star.png");
        });
    });
});

