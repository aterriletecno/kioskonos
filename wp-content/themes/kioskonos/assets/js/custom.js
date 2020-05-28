$(document).ready(function(){

    $(".btnAddFavoritos").click(function(){
        $('.tooltip').hide();
        $(this).find('.heart').toggleClass('active');
        if( $(this).find('.heart').hasClass('active') == true ){ // Agregar
            addFavorito( $(this).data('user_id'),$(this).data('product_id'),'add' );
            $(this).attr('data-original-title','Quitar de favoritos');
        } else {
            addFavorito( $(this).data('user_id'),$(this).data('product_id'),'remove' ); //Quitar
            $(this).attr('data-original-title','Agregar a favoritos');
        }
    })
    $(".heart").on('click touchstart', function(){
        $(this).toggleClass('is_animating');
    });

    /*when the animation is over, remove the class*/
    $(".heart").on('animationend', function(){
        $(this).toggleClass('is_animating');
    });

    $("a[href='#']").click(function(event){
        event.preventDefault();
    })

    if( $(window).scrollTop() > 0 ){
        $("nav.navbar").removeClass('navbar-transparent');
    }

    $(".btn-pedir-whatsapp").click(function(event){
        event.preventDefault();
        whatsapp = $(this).data('whatsapp');
        title = $(this).data('title');
        if($("[name=despacho]").val() == "Si"){
            despacho = 'con'
        } else {
            despacho = 'sin'
        }
        link = 'https://wa.me/'+whatsapp+'?text=Hola%21%20Me%20gustaría%20pedir%20' + $("[name=cuantos_quieres]").val() + '%20' + title + '%20que%20vi%20en%20kioskonos.cl,%20' + despacho + '%20despacho%20a%20domicilio,%20por%20favor';
        window.open(link);
    })

    $("img").each(function(){
        $(this).attr('srcset','');
        $(this).attr('sizes','');
    })

    $(document).keyup(function(e) {
        if (e.key === "Escape") { // escape key maps to keycode `27`
            $(".alert_overlay, .alert_container").fadeOut(300, function() {
                $(".alert_overlay, .alert_container").remove();
            });
            $.confirm.hide();
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
            <a href="javascript: alerta({ action:'close' });" class="btn btn-default pull-right">Entendido!</a>
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


addFavorito = function(prod_id,user_id,method){

    if (localStorage.getItem("kioskonos_favoritos" + user_id) === null) {
        localStorage.setItem("kioskonos_favoritos" + user_id,"["+prod_id+"]");
    } else {
        product_items = localStorage.getItem("kioskonos_favoritos" + user_id);
        json_product_items = JSON.parse(product_items);
        json_product_items.push(prod_id);
        console.log(json_product_items);
    }


    return;

    var fav_ids = [12,45,67,3];
    var existe_fav = fav_ids.includes(12);

    var kioskonos_favoritos = localStorage.getItem("kioskonos_favoritos");

    console.log( kioskonos_favoritos );

    /*
    $.ajax({
        type: 'POST',
        url: AJAX_URL,
        dataType: 'json',
        data: {
            'product_id' : prod_id,
            'user_id' : user_id,
            'method' : method
        },
        beforeSend: function(){
        },
        success: function(json){
            alerta({text:'Favorito'});
        }
    })
    */
}




function recalcular(user_id){
    total_productos = 0;
    objCart = "[";
    $(".card-product").each(function(){
        heart = $(this).find('.heart');
        button = $(this).find('.btnAddFavoritos');

        if( heart.hasClass('active') ){
            total_productos++;  
            objCart += button.data('product_id') + ',';
        }
    });

    if( total_productos > 0 ){
        objCart = objCart.substring(0, objCart.length - 1);
    }

    objCart += "]";

    sessionStorage.setItem('kioskonos_favoritos' + user_id, objCart);

}
