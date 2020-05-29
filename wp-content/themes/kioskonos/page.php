<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

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
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="the_content">
    					<?php the_content(); ?>
    				</div>
				</div>
			</div>
        </div>
    </div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
