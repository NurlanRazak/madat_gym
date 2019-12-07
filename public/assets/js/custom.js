$(".owl-carousel").owlCarousel({
	loop: true,
	nav: true,
	navText: ["<img src='../../../public/assets/images/prev.png'>","<img src='../../../public/assets/images/next.png'>"],
	responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:3
        }
    }
});