$(document).ready(function(){

    $("img").each(function(){
        $(this).attr('srcset','');
        $(this).attr('sizes','');
    })

    $(document).keyup(function(e) {
        if (e.key === "Escape") { // escape key maps to keycode `27`
            $(".alert_overlay, .alert_container").fadeOut(300, function() {
                $(".alert_overlay, .alert_container").remove();
            });
        }
    });

    if( $(window).width() < 768 ){
        $("#categoryTree").removeClass('in')
    }

    $(".btn-facebook-login").click(function(e){
        e.preventDefault();
        fbLogin();
    })

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
    if( $(window).width() < 768 ){
        $("#categoryTree").removeClass('in')
    } else {
        $("#categoryTree").addClass('in')
    }
});


alerta = function( options ) {
    var settings = $.extend({
        action: "open",
        text: ""
    }, options );

    if( settings.action == 'open' ){
        $(".alert_overlay, .alert_container").remove();
        h = `
        <div class="alert_overlay"></div>
        <div class="alert_container">
            <p>`+ settings.text +`</p>
            <a href="javascript: alerta({ action:'close' });" class="btn btn-default btn-sm pull-right">Entendido!</a>
        </div>
        `;
        $("body").append(h);
        $("html, body").css({
            'overflow' : 'hidden'
        });
        $(".alert_overlay, .alert_container").fadeIn(300);
    } else {
        $("html, body").css({
            'overflow' : 'auto'
        });
        $(".alert_overlay, .alert_container").fadeOut(300, function() {
            $(".alert_overlay, .alert_container").remove();
        });
    }

}

