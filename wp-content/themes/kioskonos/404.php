<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/lost.png');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">404<br>¿Perdido?</h1>
            </div>
        </div>
    </div>
</div>

<div class="main main-raised">
	<div class="container">
        <div class="about-description text-center">
            <div class="row">
				<div class="col-md-8 col-md-offset-2">
					<h5 class="description pt-4">La página que buscas no existe o ya no se encuentra diponible. <br>
					Intenta navegar usando el menu principal o el buscador. Tambien puedes ir a la pagina principal del sitio.</h5>
					<a href="<?php bloginfo('wpurl'); ?>" class="btn btn-round btn-success mb-5">
						Ir al inicio
					</a>
				</div>
			</div>
        </div>
    </div>
</div>
<?php get_footer(); ?>