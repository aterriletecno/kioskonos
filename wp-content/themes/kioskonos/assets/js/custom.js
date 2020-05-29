$(document).ready(function(){

    $("#register-form").submit(function(event) {
        event.preventDefault();
        if( $("#register-form [name=terminos]").prop('checked') == false ){
            alerta({text:'Debe aceptar los Términos y Condiciones para poder registrarse en KioskoNOS'});
        } else {
            $("#register-form")[0].submit();
        }
    });

    $("#contact-form").submit(function(event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            dataType: 'json',
            data: $("#contact-form").serialize() + '&action=contacto',
            beforeSend: function(){
                $("#contact-form .btn").replaceWith('<div class="text-right mr-4 enviando"><strong>Enviando...</strong></div>');
            },
            success: function(json){
                console.log(json);
                $("#contact-form")[0].reset();
                if(json.status = 'OK'){
                    button = `
                    <button type="submit" class="btn btn-success pull-right">Enviar
                        <span class="material-icons">send</span>
                    </button>
                    `;
                    $("#contact-form .enviando").replaceWith(button);
                    alerta({text:'Gracias por tu mensaje!<br>Tan pronto como nos sea posible, te contactaremos para resolver tu inqueitud.<br>Que tengas un buen dia!'});
                }
            }
        })
    })

    $(".btnInscribirNewsletter").click(function(){
        if( $("[name=newsletter_email]").val() != "" ){
            if( IsEmail( $("[name=newsletter_email]").val() ) ){
                $.ajax({
                    type: 'POST',
                    url: AJAX_URL,
                    dataType: 'json',
                    data: 'action=inscribir_newsletter&newsletter_email=' + $("[name=newsletter_email]").val(),
                    beforeSend: function(){
                    },
                    success: function(json){
                        if(json.status = 'OK'){
                            alerta({text:'Gracias por inscribirse!'});
                        }
                    }
                })
            } else {
                alerta({text:'Ingrese un email válido'});
            }
        }
    })

    $(".btnDenunciar").click(function(event){
        event.preventDefault();
        product_id = $(this).data('product_id');
        $.confirm({
            'message'   : '¿Porque quieres denunciar este producto?<br><textarea focus class="form-control" name="denuncia_descripcion"></textarea>',
            'buttons'   : {
                'Volver'    : {
                    'class' : 'btn-default pull-left'
                },
                'Enviar denuncia'   : {
                    'class' : 'btn-success pull-right',
                    'action': function(){
                        $.ajax({
                            type: 'POST',
                            url: AJAX_URL,
                            dataType: 'json',
                            data: 'action=denunciar_producto&product_id=' + product_id + '&denuncia_descripcion=' + $("[name=denuncia_descripcion]").val(),
                            beforeSend: function(){
                            },
                            success: function(json){
                                if(json.status = 'OK'){
                                    alerta({text:'Gracias por informarnos!<br>Revisaremos el producto que has denunciado para ver si infringe los términos y condiciones.'});
                                }
                            }
                        })
                    }
                }
            }
        });

    })

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $("#sidebar .sidebar-header a.cerrar").click(function(event){
        event.preventDefault();
        $('#sidebar').removeClass('active');
    })

    $(".btnAddFavoritosSingle").click(function(){
        $('.tooltip').hide();
        $(this).toggleClass('btn btn-rose btn-round btn-tooltip text-danger pr-4');
        
        if( $(this).hasClass('btn') == false ){ // Agregar
            $(this).attr('data-original-title','Quitar de favoritos');
            recalcularFavoritos( $(this).data('user_id'),$(this).data('product_id'),'add' );
        } else {
            $(this).attr('data-original-title','Agregar a favoritos');
            recalcularFavoritos( $(this).data('user_id'),$(this).data('product_id'),'remove' );
        }

    })

    $(".btnAddFavoritos").click(function(){
        $('.tooltip').hide();
        $(this).find('.heart').toggleClass('active');
        if( $(this).find('.heart').hasClass('active') == true ){ // Agregar
            $(this).attr('data-original-title','Quitar de favoritos');
            recalcularFavoritos( $(this).data('user_id'),$(this).data('product_id'),'add' );
        } else {
            $(this).attr('data-original-title','Agregar a favoritos');
            recalcularFavoritos( $(this).data('user_id'),$(this).data('product_id'),'remove' );
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


    $(".overlay, .loader").fadeOut(300);

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
        autoplay : false,
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
            <a href="javascript: alerta({ action:'close' });" class="btn btn-info pull-right">Entendido!</a>
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



function recalcularFavoritos(user_id,product_id,method){

    var post_data = {
        product_id:product_id,
        user_id:user_id, 
        action:'fav',
        method: method
    }

    $.post(AJAX_URL, post_data, function(result){
        $(".fav_counter").text(result.total_favoritos);
        $(".fav_header_list").empty();
        $.each(result.favoritos, function(k,prod){
            html = `
                <li>
                    <a href="` + WPURL + `/?post_type=productos&p=` + prod.ID + `">
                        ` + prod.post_title + `
                    </a>
                </li>
            `;
            $(".fav_header_list").append(html);
        })
        
    },'json');

}



function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}