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
        		<?php the_post_thumbnail('thumbnail'); ?>
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
									<h4 class="panel-title pull-left">Categorias</h4>
									<a  class="collapsed hidden-lg hidden-md" role="button" data-toggle="collapse" data-parent="#accordion" href="#categoryTree" aria-expanded="false" aria-controls="categoryTree" class="pull-right"><i class="fa fa-angle-down"></i></a>
									<div class="clearfix"></div>
								</div>
								<div id="categoryTree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
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

					 	<div class="col-sm-6 col-md-4 col-centered">
							<div class="card card-product">
								<div class="card-image" onclick="location.href='<?php the_permalink(); ?>'">
									<a href="<?php the_permalink() ?>">
										<?php the_post_thumbnail('product-thumbnail', ['class'=>'img','title'=>get_the_title(),'alt'=>get_the_title()]) ?>
									</a>
								</div>

								<div class="card-content">
									<h4 class="card-title">
										<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
									</h4>
									<div class="card-description">
										<?php echo excerpt(get_the_content(),12) ?>
									</div>
									<div class="footer">
		                                <div class="price">
											<h4><?php the_field('precio') ?></h4>
										</div>
		                            	<div class="stats">
											<button onclick="javascript: alerta({text:'Debes estar registrado y acceder para guardar tus favoritos'})" type="button" rel="tooltip" title="Agregar a Favoritos" class="btn btn-just-icon btn-simple btn-rose">
												<i class="fa fa-heart-o"></i>
											</button>
		                            	</div>
		                            </div>

								</div>

							</div>
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