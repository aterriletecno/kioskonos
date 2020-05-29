<?php
/**
 * Template Name: Contacto
 *
 */
if( $_POST ){
    
}
get_header(); 
while( have_posts() ) : the_post();
?>
<div class="contactus-1 section-image" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/store.jpg')">
        <div class="container pt-5">
            <div class="row">
                <div class="col-md-5">
                    <h2 class="title">Hablemos!</h2>
                    <h5 class="description">
                        Si tienes dudas, sugerencias, reclamos, felicitaciones, lo que se te ocurra, siéntete libre de enviarnos un mensaje para que podamos ayudarte.
                    </h5>
                    
                </div>
                <div class="col-md-5 col-md-offset-2">
                    <div class="card card-contact">
                        <form role="form" id="contact-form" method="post">
                            <div class="header header-raised header-primary text-center">
                                <h4 class="card-title">Escríbenos</h4>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" required>
                                        <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">Apellido</label>
                                            <input type="text" name="apellido" class="form-control" required>
                                        <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                <span class="material-input"></span></div>
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Su mensaje</label>
                                    <textarea name="mensaje" class="form-control" id="message" rows="4" required></textarea>
                                <span class="material-input"></span></div>

                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success pull-right">Enviar
                                            <span class="material-icons">send</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endwhile; ?>
<?php get_footer(); ?>
