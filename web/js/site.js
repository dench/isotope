$(function(){
    $('nav button').click(function(){
        $(this).prev().stop().slideToggle();
    });
    $('.dropdown > a').click(function(){
        $(this).next().stop().slideToggle();
    });
});