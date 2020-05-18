<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage SpoererValdes
 * @since Spoerer Valdes 1.0
 */


$args = [
	'posts_per_page' => -1,
	'post_type' => 'tiendas'
];
$tiendas = new WP_Query($args);

$args = [
	'orderby' => 'name',
    'parent'  => 0,
    'hide_empty'=> false
];
$categorias = get_categories($args);
?>
<!DOCTYPE html>
<html lang="en">
<head>
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

</head>

<body <?php body_class() ?>>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

	<div class="top-bar">
		<div class="container">
			<div class="text-right">
				<a href=""> <i class="fa fa-info-circle"></i> Terminos y condiciones</a>
				<a href=""> <i class="fa fa-usd"></i> Precios</a>
				<a href=""> <i class="fa fa-envelope-o"></i> Contacto</a>
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
        		<a class="navbar-brand" href="<?php bloginfo('wpurl') ?>">kioskoNOS</a>
        	</div>

        	<div class="collapse navbar-collapse">
        		<ul class="nav navbar-nav navbar-right">
    				<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-shopping-basket "></i> Tiendas
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-with-icons">
							<?php while ( $tiendas->have_posts() ) { $tiendas->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
							</li>
							<?php } ?>
						</ul>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-list-ul"></i> Categorias
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-with-icons">
							<?php foreach ($categorias as $category) { ?>
							<li><a href="<?php bloginfo('wpurl') ?>/?cat=<?php echo $category->cat_ID ?>"> 
								<i class="fa fa-<?php echo get_field('icon',$category) ?>"></i> &nbsp; <?php echo $category->name ?></a>
							</li>
							<?php } ?>
						</ul>
					</li>

					<li class="button-container">
						<a href="http://www.creative-tim.com/buy/material-kit-pro?ref=presentation" target="_blank" class="">
							<i class="fa fa-heart"></i><span class="badge">5</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle btn btn-round btn-success" data-toggle="dropdown">
							<i class="fa fa-user"></i>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-with-icons">
							<li>
								<a href=""> 
									<i class="fa fa-user"></i> Perfil
								</a>
							</li>
							<li>
								<a href=""> 
									<i class="fa fa-power-off"></i> Salir
								</a>
							</li>
							<li>
								<a href="<?php bloginfo('wpurl') ?>/registro"> 
									<i class="fa fa-id-card"></i> Registrarme
								</a>
							</li>
						</ul>
					</li>
        		</ul>
        	</div>
    	</div>
    </nav>