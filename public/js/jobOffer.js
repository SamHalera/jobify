$(document).ready(function(){
    $('.js-favorite-jobOffer').on('click', function(e){
        e.preventDefault();

        var $link = $(e.currentTarget);
        var $element = $('.js-favorite-jobOffer .js-icon');
        $element.toggleClass('far fa-star').toggleClass('fas fa-star');
        var $text = $('.js-favorite').html();

        $text == '' ? $content = 'favorite' : $content ='';
        $('.js-favorite').html($content);

    })
});