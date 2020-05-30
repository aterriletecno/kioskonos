<?php
/**
 * Template Name: Mis Favoritos
 *
 */
if(!session('logged')){
    header('Location: ' . get_bloginfo('wpurl') . '/login/' );
    exit();
}
get_header(); 
while( have_posts() ) : the_post();
?>
<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/store.jpg');">
	<div class="container">
		<div class="row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</div>

<div class="main main-raised">
	<div class="container">
        
        <div class="about-team team-1">
			<div class="related-products">

            <div class="row">
                <?php  
                global $wpdb;
                $favs = $wpdb->get_results('select product_id from favoritos where user_id = ' . session('user_id') );

                if( $favs ):
                foreach ($favs as $fav) :

                    $args = [
                        'post_type' => 'productos',
                        'p' => $fav->product_id
                    ];
                    $query = new WP_Query($args);
                    while( $query->have_posts() ) : $query->the_post();
                    ?>
                    <div class="col-sm-6 col-md-3">
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
                                    <?php echo excerpt(get_the_content(),12) ?>
                                </div>
                                <div class="footer">
                                    <div class="price">
                                        <span class="price price-new">$ <?php echo number_format(get_field('precio'),0,',','.') ?></span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <?php 
                    endwhile; 
                endforeach;

                else:
                ?>
                <h2 class="title text-center">Nada por aqui!!</h2>
                <h4 class="text-center">Aún no tienes nada en favoritos<br><br>Recuerda que puedes agregar tus propios favoritos haciendo click en el corazón de cada producto.<br>Con esto puedes tener los productos que más te interesan al alcance de un click <span class="material-icons">sentiment_satisfied_alt</span></h4>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
