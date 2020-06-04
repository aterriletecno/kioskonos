$(document).ready(function(){

    $(".btn-tienda-help").click(function(event){
        event.preventDefault();
        content = `
        <div id="modalTiendaHelp" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body">
                <h5 class="title text-center mb-0">¿Primera vez haciendo tu tienda?</h5>
                <h6 class="title text-center my-0 mb-3">Sigue estos consejos:</h6>
                <ul>
                    <li> Al activar tu tienda, significa que aparecerás en la lista de tiendas, donde podrás mostrar tus productos. </li>
                    <li> Si no quieres activar una tienda, está bien. Puedes navegar otras tiendas y pedir productos a tu gusto. </li>
                    <li> Procura seguir los consejos y tips que se te dan al presionar el icono de ayuda <i class="material-icons">help_outline</i> para que tengas una tienda ordenada y agradable a la vista. </li>
                    <li> Por defecto, la plataforma usa la palabra "Tienda de", seguido de tu nombre con el que te registraste. Puedes cambiar este nombre, pero evita que sea muy largo, para que tus clientes puedan recordarlo. </li>
                    <li> La descripción no es requerida, pero es bueno que des una pequeña introducción de tu tienda, para que los clientes te conozcan más.</li>
                    <li> La imagen de cabecera o "banner" aparecerá como imagen principal de fondo cuando la gente entre a revisar tu tienda o uno de tus productos. Debe ser de 1200x500 pixeles o similar tamaño proporcional.</li>
                    <li> Recuerda ingresar bien tus datos de contacto y redes sociales. Si no tienes redes sociales, no importa. Ya aprenderás a usarlas ;)</li>
                    <li> El logo de tu tienda <strong>debe ser una imagen cuadrada</strong>, ya que la plataforma la usa en esa proporción. (Evita que sea mas grande que 512x512 píxeles). </li>
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Entendido!</button>
              </div>
            </div>

          </div>
        </div>
        `;

        $("body").append(content);
        $("#modalTiendaHelp").modal('show');
    })

    $("#btnAddProduct").click(function(){
        $("#formNewModelo")[0].reset();
        $("#formNewModelo .modal-title").text('Agregar nuevo producto');
        $("#formNewModelo #product-thumbnail").attr('src',TEMPLATE_URL + '/assets/img/img_icon.png');
    })
    $(".mis-productos .btnEdit").click(function(event){
        event.preventDefault();
        product_id = $(this).data('product-id');
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            dataType: 'json',
            data: 'action=get_producto&product_id=' + product_id,
            beforeSend: function(){
            },
            success: function(json){
                $("#formNewModelo .modal-title").text('Editar producto');
                $("[name=product_id]").val( json.id );
                $("[name=nombre]").val( json.title );
                $("[name=descripcion]").val( json.descripcion );
                $("[name=precio]").val( json.precio );
                $("#product-thumbnail").attr( 'src',json.thumbnail );
                $.each(json.categorias, function(k,v){
                    $("[name='categoria[]'][value=" + v.term_id + "]").prop('checked',true);
                })
                $("#addProductModal").modal('show');
            }
        })
    })

    $("form").submit(function(){
        $(".overlay").addClass('submit');
        $(".overlay, .loader").show();
    })

    $(document).mouseup(function(e){
        var container = $("#sidebar");
        if (!container.is(e.target) && container.has(e.target).length === 0) 
        {
            container.removeClass('active');
        }
    });
    
    $("[type=number]").keydown(function(e){
        var key = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
        if(
            key == 8 || 
            key == 9 ||
            key == 13 ||
            key == 46 ||
            key == 110 ||
            key == 190 ||
            (key >= 35 && key <= 40) ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)
        ){
            return;
        } else {
            alerta({text:'Solo números en este campo'});
        }

    })

    $("#register-form").submit(function(event) {
        event.preventDefault();
        if( $("#register-form [name=terminos]").prop('checked') == false ){
            alerta({text:'Debe aceptar los Términos y Condiciones para poder registrarse en KioskoNOS'});
            $(".overlay").addClass('submit');
            $(".overlay, .loader").hide();
        } else {
            if( !checkPasswordStrength( $("[name=password]").val() ) ){
                alerta({text:'Usa una contraseña de al menos 6 caracteres de largo y mezcla números con letras'});
                $(".overlay").addClass('submit');
                $(".overlay, .loader").hide();
            } else {
                $("#register-form")[0].submit();    
            }
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
                $(".overlay").removeClass('submit');
                $(".overlay, .loader").hide();
                
                $("#contact-form")[0].reset();
                if(json.status = 'OK'){
                    button = `
                    <button type="submit" class="btn btn-success pull-right">Enviar
                        <span class="material-icons">send</span>
                    </button>
                    `;
                    $("#contact-form .enviando").replaceWith(button);
                    alerta({text:'Gracias por tu mensaje!<br>Tan pronto como nos sea posible, te contactaremos para resolver tu inquietud.<br>Que tengas un buen dia!'});
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
                            data: {
                                action: 'denunciar_producto',
                                product_id: product_id,
                                denuncia_descripcion: $("[name=denuncia_descripcion]").val()
                            },
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
            despacho = '%20con%20despacho%20a%20domicilio,';
        } else {
            despacho = '';
        }
        link = 'https://wa.me/'+whatsapp+'?text=Hola%21%20Me%20gustaría%20pedir%20' + $("[name=cuantos_quieres]").val() + '%20' + title + '%20que%20vi%20en%20kioskonos.cl,'+ despacho +'%20por%20favor';
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
        smartSpeed: 1500,
        autoplayTimeout: 7000,
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


function checkPasswordStrength(pass){
    error = 0;
    if( (/^[0-9]+$/).test(pass) ){
        error++;
    }

    if( (/^[a-zA-Z]+$/).test(pass) ){
        error++;
    }

    if( pass.length < 6 ){
        error++;
    }

    if( error > 0 ){
        return false;
    } else {
        return true;
    }
}


function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}


function copyToClipboard(elem) {
      // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
          succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }

    if(succeed){
        alerta({text:'Copiado al potapapeles'});
    }

    return succeed;
}