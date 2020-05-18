$(document).ready(function(){

    index = 0;
    setInterval(function(){ 
        max = $(".slider-home .item").length;
        if(index == max){
            index=0;
        }

        $(".slider-home .item").eq(index).fadeOut(1800); 
        if( (index + 1) == max ){
            index = -1;
        }
        $(".slider-home .item").eq(index + 1).fadeIn(1800);

        index++;

    }, 4000);


})




/* OWL INITIALIZE */
$(document).ready(function(){

    $('#banner_destacados').owlCarousel({
        items:1,
        autoplay : true,
        nav: true,
        dots: true,
        loop: true,
        navText : ['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>'],
    });


    $('#slider-home .item').height( $(window).height() )
    $('#slider-home').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items:1,
        autoplay : true,
        nav: false,
        dots: false,
        loop: true
    });

    $("#carousel-marcas").owlCarousel({
        autoplay : true,
        nav: true,
        dots: false,
        loop: true,
        navText : ['<span class="lnr lnr-chevron-left"></span>','<span class="lnr lnr-chevron-right"></span>'],
        responsive : {
            // breakpoint from 0 up
            0 : {
                items : 1
            },
            // breakpoint from 480 up
            480 : {
                items : 2
            },
            // breakpoint from 768 up
            768 : {
                items : 3
            },
            // breakpoint from 991 up
            991 : {
                items : 4
            }
        }
    })
})


$(window).on("load",function(){
    $(".overlay, .loader").delay(1000).fadeOut(300);
});

$(window).on("resize",function(){
    $('#slider-home .item').height( $(window).height() )
});
