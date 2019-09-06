$( document ).ready(function() 
{
    jumbotronHeightAdapt();
});

function jumbotronHeightAdapt()
{
    var windowHeight = $(window).height();
    $(".firstJumbo").css("height", windowHeight);
    console.log( $(window).height() );
}