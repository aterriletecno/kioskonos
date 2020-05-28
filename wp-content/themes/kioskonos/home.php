<?php
/**
 * Template Name: Home
 *
 */

get_header(); ?>


<div class="page-header header-filter" data-parallax="true">

	<div class="owl-carousel" id="slider-home">
		<div class="item" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/slide0.jpg');"></div>
		<div class="item" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/slide3.jpg');"></div>
		<div class="item" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/slide1.jpg');"></div>
		<div class="item" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/slide2.jpg');"></div>
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
					<a href=""><img src="<?php bloginfo('template_url') ?>/assets/img/banner1.jpg" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_url') ?>/assets/img/banner2.jpg" class="img-fluid"></a>
					<a href=""><img src="<?php bloginfo('template_url') ?>/assets/img/banner3.jpg" class="img-fluid"></a>
				</div>
			</div>
		</div>
	</div>
	<div class="section no-padding">
       <div class="container">
           <h2 class="section-title">Productos Destacados</h2>
           <div class="row">

           		<?php  
           		$arr = [
           			'suit-1.jpg',
					'dolce.jpg',
					'tom-ford.jpg',
					'suit-1.jpg',
					'dolce.jpg',
					'tom-ford.jpg'
           		];
           		foreach ($arr as $key => $value) { 
       			?>

                <div class="col-md-4">
					<div class="card card-product card-plain">
						<div class="card-image">
							<a href="#pablo">
								<img src="<?php bloginfo('template_url') ?>/assets/img/examples/<?php echo $value; ?>" alt="" />
							</a>
						</div>
						<div class="card-content">
							<h4 class="card-title">
								<a href="#pablo">Gucci</a>
							</h4>
							<p class="card-description">The structured shoulders and sleek detailing ensure a sharp silhouette. Team it with a silk pocket square and leather loafers.</p>
							<div class="footer">
								<div class="price-container">
									<span class="price price-old"> &euro;1,430</span>
                                   	<span class="price price-new"> &euro;743</span>
								</div>
								<div class="stats">
									<button type="button" rel="tooltip" title="" class="btn btn-just-icon btn-simple btn-rose" data-original-title="Agregar a mis Favoritos">
									   <i class="material-icons">favorite</i>
								   </button>
								</div>
                            </div>
						</div>
					</div>
                </div>
                <?php } ?>


           </div>
       </div>
	</div><!-- section -->
</div> <!-- end-main-raised -->

<div class="section section-blog">
	<div class="container pb-5">
		<h2 class="section-title">Tiendas</h2>
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
					<h3 class="title">Subscribe to our Newsletter</h3>
					<p class="description">
						Join our newsletter and get news in your inbox every week! We hate spam too, so no worries about this.
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
										<div class="form-group is-empty"><input type="email" value="" placeholder="Your Email..." class="form-control"><span class="material-input"></span></div>
									</div>
								</div>
								<div class="col-sm-4">
									<button type="button" class="btn btn-rose btn-block">Subscribe</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
