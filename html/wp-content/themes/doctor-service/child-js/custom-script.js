jQuery(function () {
    'use strict';
    jQuery(".testimonials-content").owlCarousel({
        dots:true,
        nav:false,
        loop: true,
        autoplay: true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:1,
                nav:false
            },

            800:{
                items:2,
            },
            1500:{
                items:3,
                nav:false
            }
        }
    });
});