<?php
@session_start();
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage SpoererValdes
 * @since Spoerer Valdes 1.0
 */

//Por si se elimina un usuario que aun esta logueado
$valid_user = getUserByEmail(session('email'));
if( session('logged') && !$valid_user ){
	header('Location: ' . get_bloginfo('wpurl') . '/logout');
	exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
	if( is_single() ): 
	global $post;
	?>
	<meta property="fb:app_id" content="742882742916520" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="KioskoNOS - <?php echo $post->post_title; ?>" />
	<meta property="og:description" content="<?php echo excerpt($post->post_content,20); ?>" />
	<?php  
	if( has_post_thumbnail($post->ID) ):
        $thumbSrc = get_the_post_thumbnail_url($post->ID, 'product-thumbnail');
    else:
        $thumbSrc = get_bloginfo('template_url').'/assets/img/no-img.jpg';
    endif;
	?>
	<meta property="og:image" content="<?php echo $thumbSrc; ?>" />
	<meta property="og:url" content="<?php echo $post->guid; ?>" />
	<?php else: ?>
	<meta property="fb:app_id" content="742882742916520" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="KioskoNOS" />
	<meta property="og:description" content="El primer portal de ventas, exclusivo para el sector Nos, San Bernardo" />
	<meta property="og:image" content="<?php bloginfo('template_url') ?>/assets/img/kioskonos_fb.jpg" />
	<meta property="og:url" content="<?php bloginfo('wpurl') ?>" />
	<?php endif; ?>

	<meta charset="utf-8" />
	<link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/assets/img/favicon.ico" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

	<!--   Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
	
	<!-- Lienar Icons -->
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
	
	<!-- CSS Files -->
    <link href="<?php bloginfo('template_url') ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php bloginfo('template_url') ?>/assets/css/material-kit.css?v=1.2.1" rel="stylesheet"/>

    <!-- Owl Carousel -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- Custom CSS -->
    <link href="<?php bloginfo('template_url') ?>/assets/css/custom.css?v=1.<?php echo uniqid(); ?>" rel="stylesheet"/>

    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />


    <?php wp_head(); ?>

    <script src="<?php bloginfo('template_url') ?>/assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_url') ?>/assets/js/jquery.konfirm.js"></script>

    <script> WPURL = '<?php bloginfo('wpurl') ?>'</script>
    <script> TEMPLATE_URL = '<?php bloginfo('template_url') ?>'</script>
    <script> AJAX_URL = '<?php bloginfo('template_url') ?>/ajax.php'</script>
    
    <script src="https://www.w3counter.com/tracker.js?id=132532"></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5ed2f2969d73fe001243bf10&product=inline-share-buttons&cms=sop' async='async'></script>
</head>

<body <?php body_class() ?>>
<script src="<?php bloginfo('template_url') ?>/assets/js/fb-functions.js"></script>



	<nav id="sidebar">
        <div class="sidebar-header">
            <h5 class="title">Categorías</h5>
            <a href="" class="cerrar"><i class="fa fa-times"></i></a>
        </div>
        <ul class="dropdown-menu dropdown-with-icons">
			<?php 
			$args = [
				'orderby' => 'name',
			    'parent'  => 0,
			    'hide_empty'=> false
			];
			$categorias = get_categories($args);
			foreach ($categorias as $category) { 
				if( $category->cat_ID != 1 ):
				?>
				<li><a href="<?php bloginfo('wpurl') ?>/?cat=<?php echo $category->cat_ID ?>"> 
					<i class="fa fa-<?php echo get_field('icon',$category) ?>"></i> &nbsp; <?php echo $category->name ?></a>
				</li>
				<?php 
				endif;
			} 
			?>
		</ul>
    </nav>





	<div class="top-bar">
		<div class="container">
			<div class="text-right">
				<a href="<?php bloginfo('wpurl') ?>/terminos-y-condiciones"> <i class="fa fa-info-circle"></i> Términos y condiciones</a>
				<a href="javascript: alerta({text:'Pronto tendremos precios para que puedas destacar tu tienda en nuesta plataforma.<br>Debes estar atento'})"> <i class="fa fa-usd"></i> Precios</a>
				<a href="<?php bloginfo('wpurl') ?>/contacto"> <i class="fa fa-envelope-o"></i> Contacto</a>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-default navbar-transparent navbar-fixed-top navbar-color-on-scroll" color-on-scroll="100" id="sectionsNav">
    	<div class="container">
        	<!-- Brand and toggle get grouped for better mobile display -->
        	<div class="navbar-header">
        		<button type="button" class="navbar-toggle" data-toggle="collapse">
            		<span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
        		</button>
        		<a class="navbar-brand ml-2 ml-xl-0 ml-lg-0" href="<?php bloginfo('wpurl') ?>">kioskoNOS</a>
        	</div>

        	<div class="collapse navbar-collapse">
        		<ul class="nav navbar-nav navbar-right">
    				<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="material-icons">storefront</i> Tiendas
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-with-icons">
							<?php 
							$args = [
								'posts_per_page' => -1,
								'meta_key' => 'activa',
								'meta_value' => true,
								'post_type' => 'tiendas'
							];
							$tiendas = new WP_Query($args);
							while ( $tiendas->have_posts() ) { $tiendas->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
							</li>
							<?php 
							} 
							wp_reset_postdata();
							wp_reset_query();
							?>
						</ul>
					</li>

					<li class="dropdown categorias_menu">
						<a href="#" id="sidebarCollapse" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-list-ul"></i> Categorias
							<b class="caret"></b>
						</a>
					</li>

					<?php 
					if( session('logged') ): 
					global $wpdb;
					$favs = $wpdb->get_results('select product_id from favoritos where user_id = ' . session('user_id') );
					?>
					<li class="button-container dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-heart"></i><span class="badge fav_counter"><?php echo count($favs); ?></span>
						</a>
						<ul class="dropdown-menu dropdown-with-icons fav_header_list">
							<?php 
							if($favs):
							foreach ($favs as $fav) : 
							?>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/?post_type=productos&p=<?php echo $fav->product_id; ?>">
									<?php echo get_the_title($fav->product_id) ?>
								</a>
							</li>
							<?php
							endforeach; 
							else:
							?>
							<li><a>Aun no tienes favoritos</a></li>
							<?php endif; ?>
						</ul>
					</li>
					<?php endif; ?>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle btn btn-round btn-success" data-toggle="dropdown">
							<i class="fa fa-user"></i>
							<?php 
							$username = explode(' ',session('nombre_completo'));
							echo(session('logged') ? $username[0] : ''); 
							?>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-with-icons">
							<?php if(session('logged')): ?>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/?post_type=usuarios&p=<?php echo session('user_id'); ?>"> 
									<i class="material-icons">person</i> Mi Perfil
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/mi-tienda/"> 
									<i class="material-icons">storefront</i> Mi Tienda
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/mis-favoritos/"> 
									<i class="material-icons">favorite</i> Mis Favoritos
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/logout"> 
									<i class="material-icons">power_settings_new</i> Salir
								</a>
							</li>

							<?php else: ?>

							<li>
								<a href="<?php bloginfo('wpurl') ?>/login"> 
									<i class="material-icons">fingerprint</i> Acceder
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/registro"> 
									<i class="material-icons">person_add</i> Registrarme
								</a>
							</li>

							<?php endif; ?>

						</ul>
					</li>
        		</ul>
        	</div>
    	</div>
    </nav>