<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header();
while (have_posts()) : the_post();
$tienda_id = get_the_ID();
$banner = get_field('banner');
$args = [
	'orderby' => 'id',
    'parent'  => 0,
    'hide_empty'=> false
];
$categorias = get_categories($args);
$avatar = get_field('avatar');
?>
<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php echo $banner['url'] ?>');">
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
    <div class="section">
        <div class="container">

        	<div class="avatar">
        		<img src="<?php echo $avatar['url'] ?>">
        	</div>

        	<div class="about-description text-center mt-5 pt-5">
                <div class="row">
    				<div class="col-md-8 col-md-offset-2">
    					<h5 class="description pt-4">
    						<?php the_content(); ?>
    					</h5>
    				</div>
    			</div>
            </div>

			<h2 class="section-title">Nuestros productos</h2>
			<div class="row">
				<div class="col-md-3">
					<div class="card card-refine card-plain">
						<div class="card-content">

							<div class="panel panel-default panel-rose">
								<div class="panel-heading" role="tab" id="headingThree">
									<h4 class="panel-title">Categorias</h4>
								</div>
								<div>
									<div class="panel-body">
										<?php foreach ($categorias as $category) { ?>
										<div class="checkbox">
											<label>
											   	<input type="checkbox" value="<?php echo $category->term_id; ?>" data-toggle="checkbox">
												<?php echo $category->name ?>
											</label>
										</div>
										<?php } ?>
								   </div>
							   </div>
						   </div>

						</div>
					</div><!-- end card -->
				</div>

				<div class="col-md-9">
   					<div class="row">
					 		
				 		<?php  
				 		$args = [
				 			'meta_key' => 'tienda',
				 			'meta_value' => $tienda_id,
				 			'post_type' => 'productos',
				 			'posts_per_page' => -1
				 		];
				 		$query = new WP_Query($args);
				 		while( $query->have_posts() ) : $query->the_post();
				 		?>

					 	<div class="col-md-4">
   							 <div class="card card-product card-plain no-shadow" data-colored-shadow="false">
   								 <div class="card-image" onclick="location.href='<?php the_permalink(); ?>'">
   									 <a href="<?php the_permalink(); ?>">
   										 <?php the_post_thumbnail('product-thumbnail', ['title'=>the_title(),'alt'=>the_title()]) ?>
   									 </a>
   								 </div>
   								 <div class="card-content">
   									 <a href="<?php the_permalink(); ?>">
   										 <h4 class="card-title"><?php the_title() ?></h4>
   									 </a>
   									 <p class="description">
   										<?php echo excerpt(get_the_content(),10) ?>
   									 </p>
   									 <div class="footer">
										 <div class="price-container">
										 	<span class="price"> <?php the_field('precio') ?></span>
										 </div>

   										 <button class="btn btn-rose btn-simple btn-fab btn-fab-mini btn-round pull-right" rel="tooltip" title="Remove from wishlist" data-placement="left">
   											 <i class="material-icons">favorite</i>
   										 </button>
   									 </div>
   								 </div>
   							 </div> <!-- end card -->
					  	</div>
					  	<?php  
					  	endwhile;	
					  	wp_reset_query();
					  	?>
   					</div>
   				</div>
			</div>
		
		</div>
    </div><!-- section -->

</div> <!-- end-main-raised -->


<?php endwhile; ?>
<?php get_footer(); ?>