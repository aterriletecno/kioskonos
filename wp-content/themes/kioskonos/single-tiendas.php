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
$telefono = get_field('telefono',$tienda_id);
$email = get_field('email',$tienda_id);
$whatsapp = get_field('whatsapp',$tienda_id);

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
	<div class="row desktop">
		<div class="col-xs-6 col-sm-6 col-lg-6">
			<?php if( $facebook || $instagram || $twitter || $youtube ): ?>
			<div class="pl-5">
				<div class="social-box pt-4">
					<strong>Visítanos en:</strong>
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
			</div>
			<?php endif; ?>
		</div>
		<div class="col-xs-6 col-sm-6 col-lg-6 text-right" >
			<?php if( $telefono || $email || $whatsapp ): ?>
			<div class="pr-5 social-box py-4">
				<strong>Contacta esta tienda </strong>
				
				<?php if($telefono): ?>
				<a target="_blank" href="tel:<?php echo $telefono; ?>" class="btn btn-just-icon btn-round btn-default"><i class="fa fa-phone"></i></a>
				<?php endif; ?>
				
				<?php if($email): ?>
				<a target="_blank" href="mailto:<?php the_field('email') ?>" class="btn btn-just-icon btn-round btn-danger"><i class="fa fa-envelope"></i></a>
				<?php endif; ?>

				<?php if($whatsapp): ?>
				<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo str_replace('+','',$whatsapp) ?>" class="btn btn-just-icon btn-round btn-success"><i class="fa fa-whatsapp"></i></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
    <div class="section">
        <div class="container">

        	<div class="avatar">
        		<?php 
				if( has_post_thumbnail() ):
					the_post_thumbnail('thumbnail');
				else:
					echo '<img src="'.get_bloginfo('template_url').'/assets/img/no-img.jpg" class="img" alt="'.get_the_title().'" title="'.get_the_title().'">';
				endif;
				?>
        	</div>


        	<div class="about-description text-center mt-4">
                <div class="row">
    				<div class="col-md-8 col-md-offset-2">
    					<?php if( $facebook || $instagram || $twitter || $youtube ): ?>
    					<div class="social-box pt-4 mobile">
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
    					<?php endif; ?>

    					<?php if( $telefono || $email || $whatsapp ): ?>
						<div class="social-box pt-3 mobile">
							<strong>Contacta esta tienda </strong>
							
							<?php if($telefono): ?>
							<a target="_blank" href="tel:<?php echo $telefono; ?>" class="btn btn-just-icon btn-round btn-default"><i class="fa fa-phone"></i></a>
							<?php endif; ?>
							
							<?php if($email): ?>
							<a target="_blank" href="mailto:<?php the_field('email') ?>" class="btn btn-just-icon btn-round btn-danger"><i class="fa fa-envelope"></i></a>
							<?php endif; ?>

							<?php if($whatsapp): ?>
							<a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo str_replace('+','',$whatsapp) ?>" class="btn btn-just-icon btn-round btn-success"><i class="fa fa-whatsapp"></i></a>
							<?php endif; ?>
						</div>
						<?php endif; ?>

    					<h5 class="description pt-2">
    						<?php the_content(); ?>
    					</h5>
    				</div>
    			</div>
            </div>
            <div id="product-list"></div>
			<h2 class="title text-center">Nuestros productos</h2>
			<div class="row">

				<?php 
				$args_productos = [
		 			'meta_key' => 'tienda',
		 			'meta_value' => $tienda_id,
		 			'post_type' => 'productos',
		 			'posts_per_page' => -1,
		 		];
		 		if( $_GET['cat'] ){
		 			$args_productos['cat'] = $_GET['cat'];
		 		}
		 		$query_productos = new WP_Query($args_productos);

				if($query_productos->found_posts > 0): ?>
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
				 		while( $query_productos->have_posts() ) : $query_productos->the_post();
				 		?>

					 	<div class="col-xs-6 col-sm-6 col-md-4 col-centered">
							<div class="card card-product">
								<div class="card-image" onclick="location.href='<?php the_permalink(); ?>'">
									<a href="<?php the_permalink() ?>">
										<?php 
										if( has_post_thumbnail() ):
											the_post_thumbnail('product-thumbnail', ['class'=>'img','title'=>get_the_title(),'alt'=>get_the_title()]);
										else:
											echo '<img src="'.get_bloginfo('template_url').'/assets/img/no-img.jpg" class="img" alt="'.get_the_title().'" title="'.get_the_title().'">';
										endif;
										?>
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
   				<?php else: ?>
				<div class="col-xs-12 col-lg-12 mb-5">
					<h5 class="title text-center">Aún no hay productos publicados, pero igual puedes contactar la Tienda</h5>
				</div>
   				<?php endif; ?>

   				<div class="col-lg-12 col-xs-12">
   					<div class="text-right social-box">
                        <strong class="pr-2 d-block d-lg-inline">Comparte esta tienda en:</strong>
                        <button data-toggle="tooltip" title="Facebook" onclick="window.open('https://www.facebook.com/sharer.php?t=<?php echo urlencode('Me gusta esta tienda que vi en www.kioskonos.cl') ?>&u=<?php echo urlencode(get_permalink()) ?>','','width=600,height=300')" class="btn btn-just-icon btn-round btn-facebook">
                            <i class="fa fa-facebook"> </i>
                        </button>
                        <button data-toggle="tooltip" title="Twitter" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo urlencode('Me gusta esta tienda que vi en www.kioskonos.cl: ' . get_permalink()) ?>','','width=600,height=300')" class="btn btn-just-icon btn-round btn-twitter">
                            <i class="fa fa-twitter"></i>
                        </button>
                        <button data-toggle="tooltip" title="WhatsApp" onclick="window.open('https://wa.me/?text=<?php echo urlencode('Me gusta esta tienda que vi en www.kioskonos.cl: ' . get_permalink()) ?>','','width=600,height=300')" class="btn btn-just-icon btn-round btn-success">
                            <i class="fa fa-whatsapp"></i>
                        </button>
                        <input class="invisible" id="copyTarget" value="<?php the_permalink(); ?>">
                        <button data-toggle="tooltip" title="Copiar perfil de la Tienda" onclick="copyToClipboard(document.getElementById('copyTarget'));" class="btn btn-just-icon btn-round btn-default">
                            <i class="fa fa-link"></i>
                        </button>
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