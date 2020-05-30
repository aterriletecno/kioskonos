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
$permalink = get_permalink();
$tienda_id = get_the_ID();
$banner = get_field('banner');
if( !is_array($banner) ){
	$banner = wp_get_attachment_image_src($banner,'full');
} else {
	$banner = [$banner['url']];
}
$activa = get_field('activa');

if( $activa ):

$avatar = get_field('avatar');


$categorias = [];
$args = [
	'meta_key' => 'tienda',
	'meta_value' => $tienda_id,
	'post_type' => 'productos',
	'posts_per_page' => -1
];
$query = new WP_Query($args);
while( $query->have_posts() ) : $query->the_post();
	$post_categories = get_the_category();
	foreach ($post_categories as $cat) {
		if( !in_array($cat->cat_ID,$categorias) ){
			$categorias[] = $cat->cat_ID;
		}
	}
endwhile;
wp_reset_query();

$facebook = get_field('facebook',$tienda_id);
$instagram = get_field('instagram',$tienda_id);
$twitter = get_field('twitter',$tienda_id);
$youtube = get_field('youtube',$tienda_id);

?>
<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php echo $banner[0] ?>');">
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


        	<div class="about-description text-center mt-4">
                <div class="row">
    				<div class="col-md-8 col-md-offset-2">
    					<div class="social pt-4">
    						<strong>Visítanos en:</strong><br>
    						<?php if($facebook): ?>
    						<a href="<?php echo $facebook; ?>" target="_blank" data-toggle="tooltip" title="Facebook" class="mx-1 btn btn-just-icon btn-round btn-facebook">
	                			<i class="fa fa-facebook"> </i>
	                		</a>
	                		<?php endif; ?>

	                		<?php if($instagram): ?>
	                		<a href="<?php echo $instagram; ?>" target="_blank" data-toggle="tooltip" title="Instagram" class="mx-1 btn btn-just-icon btn-round btn-instagram">
	                			<i class="fa fa-instagram"> </i>
	                		</a>
	                		<?php endif; ?>

	                		<?php if($twitter): ?>
	                		<a href="<?php echo $twitter; ?>" target="_blank" data-toggle="tooltip" title="Twitter" class="mx-1 btn btn-just-icon btn-round btn-twitter">
	                			<i class="fa fa-twitter"> </i>
	                		</a>
	                		<?php endif; ?>

	                		<?php if($youtube): ?>
	                		<a href="<?php echo $youtube; ?>" target="_blank" data-toggle="tooltip" title="Youtube" class="mx-1 btn btn-just-icon btn-round btn-youtube">
	                			<i class="fa fa-youtube"> </i>
	                		</a>
	                		<?php endif; ?>

	                		

    					</div>
    					<h5 class="description pt-2">
    						<?php the_content(); ?>
    					</h5>
    				</div>
    			</div>
            </div>
            <div id="product-list"></div>
			<h2 class="title text-center">Nuestros productos</h2>
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
										if($category != 1):
										$selected_categories = explode(",",$_GET['cat']);
										
										$checked = "";
										if( in_array($category,$selected_categories) ){
											$checked = "checked";
										}
										?>
										<div class="checkbox">
											<label>
											   	<input type="checkbox" value="<?php echo $category; ?>" data-toggle="checkbox" <?php echo $checked; ?>>
												<?php echo get_cat_name($category); ?>
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
				 			'meta_key' => 'tienda',
				 			'meta_value' => $tienda_id,
				 			'post_type' => 'productos',
				 			'posts_per_page' => -1,
				 		];
				 		if( $_GET['cat'] ){
				 			$args['cat'] = $_GET['cat'];
				 		}
				 		$query = new WP_Query($args);
				 		while( $query->have_posts() ) : $query->the_post();
				 		?>

					 	<div class="col-xs-6 col-sm-6 col-md-4 col-centered">
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
					  	wp_reset_query();
					  	?>
   					</div>
   				</div>
			</div>
		
		</div>
    </div><!-- section -->

</div> <!-- end-main-raised -->


<script>
	
$(".category_list input[type=checkbox]").change(function(){
	cat = [];
	$(".category_list input[type=checkbox]").each(function(){
		if( $(this).prop('checked') == true ){
			cat.push($(this).val());
		}
	})
	$(".overlay").addClass('submit');
    $(".overlay, .loader").show();
	
    window.location.href = '<?php echo $permalink ?>?cat=' + cat.join() + '#product-list';

})

</script>

<?php else: ?>
<script> window.location.href = '<?php bloginfo('wpurl'); ?>' </script>	
<?php endif; ?>

<?php endwhile; ?>
<?php get_footer(); ?>