$(document).ready(function() {

    /*
    * Barre de recherche
    */
    $( ".btnSearch" ).click(function() {
        $(".search").animate({'right': '-50px'}, "slow");
        $(".btnSearch").css('display', 'none');
    });
    $( ".btnClose" ).click(function() {
        $(".search").animate({'right': '-300px'}, "slow");
        $(".btnSearch").css('display', 'block');
    });





    /*
    * Newsletter
    */
    $( ".btnNewsletter" ).click(function() {
        $(".newsletter").removeClass('newsletterNone');
    });
    $( ".newsletterClose" ).click(function() {
        $(".newsletter").addClass('newsletterNone');
    });

});