<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); 

$args = [
	'orderby' => 'id',
    'parent'  => 0,
    'hide_empty'=> true,
];
$categorias = get_categories($args);

$category = get_queried_object();
$this_cat = $category->term_id;
?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/store.jpg');">
	<div class="container">
		<div class="row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title"><?php single_cat_title('') ?></h1>
            </div>
        </div>
    </div>
</div>


<div class="main main-raised">
	<div class="container">
        
        <div class="about-team team-1">
			<div class="related-products">

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
										<div class="panel-body category_list">
											<?php 
											foreach ($categorias as $category) { 
											if($category->cat_ID != 1):
											?>
											<div class="checkbox" onclick="location.href='<?php bloginfo('wpurl') ?>/category/<?php echo $category->slug ?>'">
												<label>
												   	<input type="checkbox" value="<?php echo $category->cat_ID; ?>" data-toggle="checkbox" <?php echo ($this_cat == $category->cat_ID) ? 'checked' : ''; ?>>
													<?php echo get_cat_name($category->cat_ID); ?>
												</label>
											</div>
											<?php 
											endif;
											} 
											?>
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
					 			'post_type' => 'productos',
					 			'posts_per_page' => -1,
					 			'cat' => $this_cat
					 		];
					 		$query = new WP_Query($args);
					 		if( $query->have_posts() ):
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
												<?php echo excerpt(get_the_content(),10) ?>
											</div>
											<div class="footer">
				                                <div class="price">
													<h4><span class="price price-new">$ <?php echo number_format(get_field('precio'),0,',','.') ?></span></h4>
												</div>
				                            	<div class="stats">
				                            		<?php if(session('logged')): ?>
													<button data-user_id="<?php echo session('user_id'); ?>" data-product_id="<?php echo get_the_ID(); ?>" type="button" rel="tooltip" title="<?php echo (isFav(session('user_id'),get_the_ID())) ? 'Quitar de' : 'Agregar a' ?> Favoritos" class="btn btn-just-icon btn-simple btn-rose btnAddFavoritos">
														<div class="heart <?php echo (isFav(session('user_id'),get_the_ID())) ? 'active' : '' ?>"></div>
													</button>
													<?php else: ?>
													<button onclick="javascript: alerta({text:'Debes estar registrado y acceder para guardar tus favoritos'})" type="button" rel="tooltip" title="Agregar a Favoritos" class="btn btn-just-icon btn-simple btn-rose">
														<div class="heart"></div>
													</button>
													<?php endif; ?>
				                            	</div>
				                            </div>

										</div>

									</div>
								</div>
							  	<?php  
							  	endwhile;	
						  	else :
						  		?>
						  		<h4 class="title text-center">No hay productos en la categoría seleccionada</h4>
						  		<?php
						  	endif;
						  	?>
	   					</div>
	   				</div>
				</div>
        </div>
        </div>
    </div>
</div>



			

<?php get_footer(); ?>
