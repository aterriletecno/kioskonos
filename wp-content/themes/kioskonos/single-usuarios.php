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
?>

<div class="page-header header-filter header-small" data-parallax="true" style="background-image: url('<?php bloginfo('template_url') ?>/assets/img/registro-bg.jpg');">
	<div class="container">
		<div class="row title-row">
    		<div class="col-md-8 col-md-offset-2">
                <h1 class="title">Perfil de usuario</h1>
            </div>
        </div>
    </div>
</div>

<div class="profile-page">
	<div class="main main-raised">
		<div class="profile-content">
	        <div class="container">

	            <div class="row">
	                <div class="col-xs-6 col-xs-offset-3">
	    	           <div class="profile">
	                        <div class="avatar">
	                            <img src="<?php bloginfo('template_url') ?>/assets/img/placeholder.jpg" alt="...">
	                        </div>
	                        <div class="name">
	                            <h3 class="title"><?php the_title(); ?></h3>	
							</div>
	                    </div>
		            </div>
	            </div>

	            <form method="post" action="">
		            <div class="row row-centered pb-5">
						<div class="col-centered col-lg-6 col-md-12 col-xs-12">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">face</i>
								</span>
								<input type="text" class="form-control" placeholder="Nombre completo..." value="<?php the_title(); ?>" required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">email</i>
								</span>
								<input type="text" class="form-control" placeholder="Email..." value="<?php the_field('email') ?>" disabled required>
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">lock_outline</i>
								</span>
								<input type="password" placeholder="Password..." class="form-control" value="<?php the_field('password'); ?>" required />
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-success">Gurdar &nbsp; <i class="material-icons">save</i></button>
							</div>
		            	</div>
					</div>
				</form>

	        </div>
	    </div>
	</div>
</div>


<?php endwhile; ?>
<?php get_footer(); ?>