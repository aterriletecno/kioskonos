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
$tienda = get_field('tienda');
if( is_object($tienda) ){
    $tienda = $tienda->ID;
}

$banner = get_field('banner',$tienda);
if( !is_array($banner) ){
    $banner = wp_get_attachment_image_src($banner,'full');
} else {
    $banner = [$banner['url']];
}

$gallery = get_field('galeria_de_fotos');
if( !$gallery ){
    $gallery = [['url'=>get_the_post_thumbnail_url(get_the_ID(),'full')]];
}
?>


<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php echo $banner[0] ?>');">
	<div class="container" style="padding-top: 13vh">
        <div class="row title-row">
            <div class="col-lg-12">
				<h2 class="title text-center">
					<?php echo get_the_title($tienda); ?>
				</h2>
            </div>
        </div>
    </div>
</div>

<div class="section section-gray">
    <div class="container">
        <div class="main main-raised main-product">
            <div class="row">
                <div class="col-md-6 col-sm-6">

                   <div class="tab-content">
                    	<?php
                        $i=0;
                        foreach ($gallery as $foto) { ?>
                        <div class="tab-pane <?php echo ($i==0) ? 'active' : ''; ?>" id="product-page<?php echo $foto['id'] ?>">
                            <a href="<?php echo $foto['url'] ?>" class="zoom" data-fancybox>
                                <img src="<?php echo $foto['url'] ?>"/>
                            </a>
                        </div>
                        <?php 
                        $i++;
                        } 
                      	?>
                    </div>
                    <ul class="nav flexi-nav" role="tablist">
                    	<?php 
                        if( $gallery ):
                        	$i=0;
                        	foreach ($gallery as $foto) { ?>
    						<li>
    							<a href="#product-page<?php echo $foto['id'] ?>" role="tab" data-toggle="tab" aria-expanded="<?php echo ($i==0) ? 'true' : 'false'; ?>">
    								<img src="<?php echo $foto['url'] ?>"/>
    							</a>
    						</li>
                          	<?php 
                          	$i++;
                          	} 
                        endif;
                      	?>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-6">
					<h2 class="title"> <?php the_title(); ?> </h2>
					<h3 class="main-price"><span class="price price-new">$ <?php echo number_format(get_field('precio'),0,',','.') ?></span></h3>
					<div id="acordeon">
                        <div class="panel-group" id="accordion">
                      <div class="panel panel-border panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <a role="button">
                                <h4 class="panel-title">Descripción</h4>
                            </a>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                          <div class="panel-body">
                           	<?php the_content(); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div><!--  end acordeon -->

		            <div class="row pick-size">
                        <div class="col-md-6 col-sm-6">
                            <label>¿Cuántos quieres?</label>
							<select class="selectpicker" name="cuantos_quieres" data-style="select-with-transition" data-size="7">
								<?php for($i=1;$i<=20;$i++): ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php endfor; ?>
								<option value="20+">Más de 20</option>
							</select>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label>¿Quieres con despacho a domicilio?</label>
							<select class="selectpicker" name="despacho" data-style="select-with-transition" data-size="7">
								<option value="Si">Si </option>
								<option value="No">No</option>
							</select>
                        </div>
                    </div>
                    <div class="row text-right">
                    	<?php if(session('logged')): ?>
                        <?php if( isFav(session('user_id'),get_the_ID()) ): ?>
                        <a class="btnAddFavoritosSingle text-danger pr-4" data-user_id="<?php echo session('user_id') ?>" data-product_id="<?php echo get_the_ID(); ?>" data-toggle="tooltip" data-placement="top" title="Quitar de Favoritos">
                            <i class="fa fa-heart"></i>
                        </a>
                        <?php else: ?>
                        <a href="#" class="btn btn-rose btn-round btn-tooltip btnAddFavoritosSingle" data-user_id="<?php echo session('user_id') ?>" data-product_id="<?php echo get_the_ID(); ?>" data-toggle="tooltip" data-placement="top" title="Agregar a Favoritos">
                            <span class="hidden-md hidden-lg">Agregar a favoritos &nbsp; </span><i class="fa fa-heart"></i>
                        </a>
                        <?php endif; ?>
                        <span  class="pl-2"><strong>Pedir:</strong></span>
                    	<a href="https://m.me/aterrile" class="btn btn-facebook btn-round btn-tooltip" data-toggle="tooltip" data-placement="top" title="Pedir por Facebook Messenger" target="_blank">
						    <span class="hidden-md hidden-lg">Pedir por Messenger &nbsp; </span><i class="fa fa-facebook"></i>
					 	</a>
                        <a href="#" class="btn btn-success btn-round btn-tooltip btn-pedir-whatsapp" data-title="<?php the_title(); ?>" data-whatsapp="<?php echo str_replace('+','',get_field('whatsapp',$tienda)) ?>" data-toggle="tooltip" data-placement="top" title="Pedir por WhatsApp" target="_blank">
                        	<span class="hidden-md hidden-lg">Pedir por Whatsapp &nbsp; </span><i class="fa fa-whatsapp"></i>
                        </a>
                        <?php else: ?>
                        <a href="<?php bloginfo('wpurl'); ?>/login/?redirect=<?php echo urlencode(get_permalink()) ?>" class="btn btn-rose btn-round btn-tooltip" data-toggle="tooltip" data-placement="top" title="Ingresa o registrate">
                            Ingresa para poder pedir
                        </a>
                        <?php endif; ?>

                        <div class="clearfix"></div>
                        <a href="#" class="pull-right mt-5 text-black btnDenunciar" data-product_id="<?php echo get_the_ID(); ?>">
                            <small>Denunciar &nbsp; <i class="fa fa-bullhorn"></i></small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

		<div class="related-products">
			<h3 class="title text-center">Otros productos de la tienda:</h3>

			<div class="row">
				<?php  
                $args = [
                    'meta_key' => 'tienda',
                    'meta_value' => $tienda,
                    'post_type' => 'productos',
                    'posts_per_page' => 4,
                    'orderby' => 'rand'
                ];
                $query = new WP_Query($args);
                while( $query->have_posts() ) : $query->the_post();
                ?>
				<div class="col-sm-6 col-md-3">
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
    </div>
</div>


<?php endwhile; ?>
<?php get_footer(); ?>