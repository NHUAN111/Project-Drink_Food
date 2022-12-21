$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop()) {
            $('#header').addClass('sticky');
            $('.navbar-item-link').addClass('sticky-color');
        } else {
            $('#header').removeClass('sticky');
            $('.navbar-item-link').removeClass('sticky-color');
        }
    });
});

$(document).ready(function() {
    $('.slider-js').owlCarousel({
        loop: true,
        margin: 15,
        nav: false,
        autoplay: true,
        autoplayTimeout: 2500,
        smartSpeed: 1200,
        responsive: {
            0: {
                items: 1
            },
            739: {
                items: 2
            },
            1050: {
                items: 3
            }
        }
    })
});