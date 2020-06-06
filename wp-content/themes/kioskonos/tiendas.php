<?php
/**
 * Template Name: Tiendas
 *
 */

get_header(); 
while( have_posts() ) : the_post();
?>
<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo( 'template_url' ); ?>/assets/img/store.jpg');">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="brand" style="z-index: 9999">
					<h1 class="title text-center"><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="main main-raised">
	<div class="section" id="tiendas">
        <div class="container">
        	<div class="row">
        	<?php  
        	$args = [
				'posts_per_page' => -1,
				'post_type' => 'tiendas',
				'meta_key' => 'activa',
				'meta_value' => true
 			];
			$tiendas = new WP_Query($args);
			while ( $tiendas->have_posts() ) : $tiendas->the_post();
			?>

			<div class="col-xs-6 col-md-4 col-lg-3 col-xl-3">
				<div class="tienda-item">
					<a href="<?php the_permalink(); ?>" data-toggle="tooltip" title="<?php the_title(); ?>">
					<?php 
					if( has_post_thumbnail() ):
						the_post_thumbnail( 'product-thumbnail', [ 'class' => 'img-responsive img rounded' ] );
					else:
						echo '<img src="'.get_bloginfo('template_url').'/assets/img/no-img.jpg" class="img-responsive img" alt="'.get_the_title().'" title="'.get_the_title().'">';
					endif;
					?>
					<h4 class="title text-center"><?php the_title(); ?> &nbsp; </h4>
					</a>
				</div>
			</div>

			<?php	
			endwhile;
			wp_reset_postdata();
        	?>
        	</div>
        </div>
    </div><!-- section -->

</div> <!-- end-main-raised -->


<?php endwhile; ?>
<?php get_footer(); ?>
