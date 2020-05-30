<?php
/**
 * Template Name: Home
 *
 */

get_header(); 
while( have_posts() ) : the_post();
$banners = get_field('items');
?>


<div class="page-header header-filter" data-parallax="true">
	<div class="owl-carousel" id="slider-home">
		<?php  
		$slides = array('slide0.jpg', 'slide3.jpg', 'slide1.jpg', 'slide2.jpg');
		shuffle($slides);
		foreach ($slides as $slide) {
		?>
		<div class="item" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/<?php echo $slide; ?>');"></div>
		<?php } ?>
	</div>
	<div class="brand">
		<h1 class="title">
			<img src="<?php bloginfo('template_url') ?>/assets/img/logo.png">
		</h1>
		<h4>El primer portal de ventas, exclusivo para el sector Nos</h4>
	</div>

</div>

<div class="main main-raised" style="overflow: hidden;">
	<div class="section no-padding">
		<div class="row">
			<div class="col-lg-12">
				<div class="owl-carousel" id="banner_destacados">
					<?php foreach ($banners as $item) { ?>
					<div class="item <?php echo $item['claridad'] ?> <?php echo $item['alineacion'] ?>">
						<div class="floating">
							<h1 class="title"><?php echo $item['titulo'] ?></h1>
							
							<?php if( $item['bajada'] ): ?>
							<p><?php echo $item['bajada'] ?></p>
							<?php endif; ?>
							
							<?php if( $item['link'] ): ?>
							<a href="<?php echo $item['link'] ?>" class="btn btn-lg btn-round btn-success">Ver más</a>
							<?php endif; ?>
							
						</div>
						<img src="<?php echo $item['foto']['sizes']['banner-tienda'] ?>" class="img-fluid">
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="section no-padding">
       <div class="container">
           <h2 class="title text-center">Productos Destacados</h2>
           <div class="row">

           		<?php  
           		$args = [
           			'post_type' => 'productos',
           			'posts_per_page' => 6
           		];
           		$query = new WP_Query($args);
           		while( $query->have_posts() ) : $query->the_post();
       			?>
                <div class="col-md-4">
					<div class="card card-product card-plain">
						<a href="<?php the_permalink(); ?>">
							<div class="card-image">
								<?php 
								if( has_post_thumbnail() ):
									the_post_thumbnail('product-thumbnail', ['title'=>get_the_title(),'alt'=>get_the_title()]);
								else:
									echo '<img src="'.get_bloginfo('template_url').'/assets/img/no-img.jpg" class="img" alt="'.get_the_title().'" title="'.get_the_title().'">';
								endif;
								?>
							</div>
						</a>
						<div class="card-content">
							<h4 class="card-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<p class="card-description">
								<?php 
								if( get_the_content() != "" ){
									echo excerpt(get_the_content(),12);
								} else {
									echo "[Producto sin descripción]";
								}
								?>
							</p>
							<div class="footer">
								<div class="price-container">
                                   	<span class="price price-new">$ <?php echo number_format(get_field('precio'),0,',','.') ?></span>
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
                <?php endwhile; ?>

           </div>
       </div>
	</div><!-- section -->
</div> <!-- end-main-raised -->

<div class="section section-blog pb-0">
	<div class="container pb-5">
		<h2 class="title text-center">Tiendas Destacadas</h2>
		<div class="row">
			<div class="owl-carousel" id="carousel-marcas">
			<?php 
			$args = [
				'posts_per_page' => -1,
				'post_type' => 'tiendas'
			];
			$tiendas = new WP_Query($args);
			while ($tiendas->have_posts()) : $tiendas->the_post();
			?>
				<div style="padding: 0 30px">
				<div class="card card-product">
					<div class="card-content">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('product-thumbnail') ?>
						</a>
					</div>
				</div>
				</div>
			<?php endwhile; ?>
		</div>

	</div>
</div><!-- section -->

<div class="subscribe-line subscribe-line-image" data-parallax="true"  style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/news.jpg');">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="text-center">
					<h3 class="title">Inscríbete al Newsletter</h3>
					<p class="description">
						Ingresa tu email para recibir noticias y novedades del sitio.<br>
						(No compartiremos tu correo)
					</p>
				</div>

				<div class="card card-raised card-form-horizontal">
					<div class="card-content">
						<form method="" action="">
							<div class="row">
								<div class="col-sm-8">

									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">mail</i>
										</span>
										<div class="form-group is-empty">
											<input type="email" name="newsletter_email" value="" placeholder="Tu Email..." class="form-control">
											<span class="material-input"></span>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<button type="button" class="btn btn-rose btn-block btnInscribirNewsletter">Inscribirse</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
